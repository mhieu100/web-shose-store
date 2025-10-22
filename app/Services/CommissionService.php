<?php

namespace App\Services;

use App\Models\AffiliateLink;
use App\Models\Commission;
use App\Models\Shop\Order;
use App\Models\User;

class CommissionService
{
    /**
     * Process commission for an order
     */
    public function processOrderCommission(Order $order): ?Commission
    {
        // Check if order has affiliate referral
        if (!$order->hasAffiliate()) {
            return null;
        }

        // Check if commission already exists
        $existingCommission = Commission::where('order_id', $order->id)
                                       ->where('user_id', $order->affiliate_user_id)
                                       ->first();
        
        if ($existingCommission) {
            return $existingCommission;
        }

        $affiliateUser = $order->affiliateUser;
        if (!$affiliateUser || !$affiliateUser->isActiveAffiliate()) {
            return null;
        }

        // Calculate commission
        $commissionAmount = $order->calculateAffiliateCommission();
        
        if ($commissionAmount <= 0) {
            return null;
        }

        // Determine product_id based on affiliate link
        $productId = null;
        if ($order->affiliate_link_code) {
            $affiliateLink = AffiliateLink::where('link_code', $order->affiliate_link_code)
                                         ->where('user_id', $affiliateUser->id)
                                         ->first();
            if ($affiliateLink) {
                $productId = $affiliateLink->shop_product_id;
            }
        }
        
        // Fallback to first item if no specific affiliate link
        if (!$productId) {
            $productId = $order->items->first()?->shop_product_id;
        }

        // Create commission record
        $commission = Commission::create([
            'user_id' => $affiliateUser->id,
            'order_id' => $order->id,
            'product_id' => $productId,
            'order_amount' => $order->total_price,
            'commission_rate' => $affiliateUser->commission_rate,
            'commission_amount' => $commissionAmount,
            'status' => 'pending',
            'notes' => "Hoa hồng từ đơn hàng #{$order->number} - Mã CTV: {$affiliateUser->affiliate_code}",
        ]);

        // Update affiliate link conversion if applicable
        if ($order->affiliate_link_code) {
            $affiliateLink = AffiliateLink::where('link_code', $order->affiliate_link_code)
                                         ->where('user_id', $affiliateUser->id)
                                         ->first();
            
            if ($affiliateLink) {
                $affiliateLink->recordConversion($commissionAmount);
            }
        }

        return $commission;
    }

    /**
     * Auto-approve commissions for trusted affiliates
     */
    public function autoApproveCommission(Commission $commission): bool
    {
        $user = $commission->user;
        
        // Auto-approve for users with good track record
        $totalPaidCommissions = $user->getTotalPaidCommissions();
        $totalCommissions = $user->commissions()->count();
        
        // Auto-approve if user has been paid before and has good history
        if ($totalPaidCommissions > 0 && $totalCommissions >= 5) {
            $commission->update([
                'status' => 'approved',
                'approved_at' => now(),
                'notes' => $commission->notes . ' - Tự động duyệt'
            ]);
            
            return true;
        }

        return false;
    }

    /**
     * Get commission statistics for a user
     */
    public function getUserCommissionStats(User $user): array
    {
        return [
            'total_commissions' => $user->commissions()->count(),
            'total_amount' => $user->commissions()->sum('commission_amount'),
            'pending_amount' => $user->getTotalPendingCommissions(),
            'approved_amount' => $user->getTotalApprovedCommissions(),
            'paid_amount' => $user->getTotalPaidCommissions(),
            'this_month_amount' => $user->commissions()
                                       ->whereMonth('created_at', now()->month)
                                       ->whereYear('created_at', now()->year)
                                       ->sum('commission_amount'),
            'conversion_rate' => $this->calculateConversionRate($user),
        ];
    }

    /**
     * Calculate overall conversion rate for user
     */
    protected function calculateConversionRate(User $user): float
    {
        $totalClicks = $user->affiliateLinks()->sum('clicks');
        $totalConversions = $user->affiliateLinks()->sum('conversions');
        
        if ($totalClicks === 0) {
            return 0;
        }

        return round(($totalConversions / $totalClicks) * 100, 2);
    }

    /**
     * Generate affiliate code for user
     */
    public function generateAffiliateCodeForUser(User $user): string
    {
        if ($user->affiliate_code) {
            return $user->affiliate_code;
        }

        $code = $user->generateAffiliateCode();
        $user->update([
            'affiliate_code' => $code,
            'is_affiliate_active' => true,
        ]);

        return $code;
    }

    /**
     * Track affiliate referral from session
     */
    public function trackAffiliateReferral(Order $order): void
    {
        $affiliateUserId = session('affiliate_user_id');
        $affiliateCode = session('affiliate_code');
        $affiliateLinkCode = session('affiliate_link_code');
        
        if ($affiliateUserId && $affiliateCode) {
            $order->update([
                'affiliate_user_id' => $affiliateUserId,
                'affiliate_code' => $affiliateCode,
                'affiliate_link_code' => $affiliateLinkCode,
            ]);

            // Clear session data after tracking
            session()->forget(['affiliate_user_id', 'affiliate_code', 'affiliate_link_code']);
            
            // Process commission
            $this->processOrderCommission($order);
        }
    }

    /**
     * Process payment for a commission and add to wallet
     */
    public function processCommissionPayment(Commission $commission): bool
    {
        if ($commission->status !== 'approved') {
            return false;
        }

        try {
            // Update commission status
            $commission->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            // Add funds to user's wallet
            $walletService = app(\App\Services\WalletService::class);
            $wallet = $walletService->getOrCreateWallet($commission->user);
            
            $wallet->addFunds(
                $commission->commission_amount,
                'commission',
                "Hoa hồng từ đơn hàng #{$commission->order_id} - Mã CTV: {$commission->user->affiliate_code}",
                $commission->order_id,
                ['commission_id' => $commission->id]
            );

            return true;

        } catch (\Exception $e) {
            \Log::error('Commission payment failed', [
                'commission_id' => $commission->id,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Fix existing paid commissions that weren't added to wallets
     */
    public function fixExistingPaidCommissions(): array
    {
        $results = ['processed' => 0, 'failed' => 0, 'errors' => []];
        
        // Get paid commissions that don't have corresponding wallet transactions
        $paidCommissions = Commission::where('status', 'paid')
            ->whereNotNull('paid_at')
            ->with('user')
            ->get();

        $walletService = app(\App\Services\WalletService::class);

        foreach ($paidCommissions as $commission) {
            try {
                // Check if wallet transaction already exists for this commission
                $existingTransaction = \App\Models\Shop\WalletTransaction::where('user_id', $commission->user_id)
                    ->where('type', 'commission')
                    ->where('order_id', $commission->order_id)
                    ->where('amount', $commission->commission_amount)
                    ->first();

                if (!$existingTransaction) {
                    // Add funds to wallet
                    $wallet = $walletService->getOrCreateWallet($commission->user);
                    
                    $wallet->addFunds(
                        $commission->commission_amount,
                        'commission',
                        "Hoa hồng từ đơn hàng #{$commission->order_id} - Mã CTV: {$commission->user->affiliate_code} (Bổ sung)",
                        $commission->order_id,
                        ['commission_id' => $commission->id, 'retroactive' => true]
                    );

                    $results['processed']++;
                }

            } catch (\Exception $e) {
                $results['failed']++;
                $results['errors'][] = "Commission ID {$commission->id}: " . $e->getMessage();
                \Log::error('Failed to fix commission payment', [
                    'commission_id' => $commission->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $results;
    }
}