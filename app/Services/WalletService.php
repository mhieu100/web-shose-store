<?php

namespace App\Services;

use App\Models\Shop\Order;
use App\Models\Shop\UserWallet;
use App\Models\Shop\WalletTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WalletService
{
    protected PayPalService $paypalService;

    public function __construct(PayPalService $paypalService)
    {
        $this->paypalService = $paypalService;
    }

    /**
     * Get or create user wallet
     */
    public function getOrCreateWallet(User $user): UserWallet
    {
        return UserWallet::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 0, 'currency' => 'VND']
        );
    }

    /**
     * Process refund when order is cancelled
     */
    public function processRefund(Order $order): bool
    {
        // Check if order has payment and is paid
        $payment = $order->payment;

        if (!$payment || $payment->status !== 'completed') {
            return false; // No payment or not paid yet, no refund needed
        }

        // Check if already refunded
        if ($payment->status === 'refunded') {
            return true;
        }

        DB::beginTransaction();
        try {
            $refundAmount = $payment->amount;
            $wallet = $this->getOrCreateWallet($order->user);

            switch ($payment->provider) {
                case 'paypal':
                    // Try to refund via PayPal API
                    $paypalRefund = $this->refundViaPayPal($payment);

                    if ($paypalRefund) {
                        // PayPal refund successful
                        $wallet->addFunds(
                            $refundAmount,
                            'refund',
                            "Hoàn tiền đơn hàng #{$order->id} qua PayPal",
                            $order->id,
                            ['paypal_refund_id' => $paypalRefund['id'] ?? null]
                        );
                    } else {
                        // PayPal refund failed, add to wallet balance
                        $wallet->addFunds(
                            $refundAmount,
                            'refund',
                            "Hoàn tiền đơn hàng #{$order->id} vào ví (PayPal không khả dụng)",
                            $order->id
                        );
                    }
                    break;

                case 'cod':
                    // COD orders don't need refund (not paid yet)
                    DB::commit();
                    return true;

                case 'bank_transfer':
                default:
                    // Add to wallet balance for manual withdrawal
                    $wallet->addFunds(
                        $refundAmount,
                        'refund',
                        "Hoàn tiền đơn hàng #{$order->id} vào ví",
                        $order->id
                    );
                    break;
            }

            // Update payment status
            $payment->update([
                'status' => 'refunded',
            ]);

            // Update order payment_status if exists
            if ($order->payment_status) {
                $order->update([
                    'payment_status' => 'refunded',
                ]);
            }

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Refund processing failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Refund payment via PayPal
     */
    protected function refundViaPayPal($payment): ?array
    {
        try {
            // Get PayPal payment ID from metadata
            $metadata = is_string($payment->metadata)
                ? json_decode($payment->metadata, true)
                : $payment->metadata;

            $paypalPaymentId = $metadata['paypal_payment_id'] ?? null;

            if (!$paypalPaymentId) {
                Log::warning('No PayPal payment ID found in payment metadata', [
                    'payment_id' => $payment->id,
                ]);
                return null;
            }

            // Call PayPal refund API
            $refund = $this->paypalService->refundPayment($paypalPaymentId);

            return $refund;

        } catch (\Exception $e) {
            Log::error('PayPal refund failed', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Get wallet balance for user
     */
    public function getBalance(User $user): float
    {
        $wallet = UserWallet::where('user_id', $user->id)->first();
        return $wallet ? (float) $wallet->balance : 0.0;
    }

    /**
     * Get wallet transactions for user
     */
    public function getTransactions(User $user, int $limit = 10)
    {
        return WalletTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
