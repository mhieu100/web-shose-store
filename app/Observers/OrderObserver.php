<?php

namespace App\Observers;

use App\Models\Shop\Order;
use App\Services\CommissionService;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    protected $commissionService;

    public function __construct(CommissionService $commissionService)
    {
        $this->commissionService = $commissionService;
    }

    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        // Track affiliate referral and process commission
        $this->commissionService->trackAffiliateReferral($order);
        
        // Send order confirmation email
        $this->sendOrderConfirmationEmail($order);
    }

    /**
     * Send order confirmation email to customer
     */
    private function sendOrderConfirmationEmail(Order $order): void
    {
        try {
            // Load the order with necessary relationships
            $order->load(['items.product', 'user']);
            
            // Check if user has email
            if ($order->user && $order->user->email) {
                Log::info('Sending order confirmation email', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'user_email' => $order->user->email
                ]);
                
                Mail::to($order->user->email)->send(new OrderConfirmationMail($order));
                
                Log::info('Order confirmation email sent successfully', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number
                ]);
            } else {
                Log::warning('Cannot send order confirmation email - no user email', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send order confirmation email', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        // If order status changed to completed, auto-approve commission for trusted users
        if ($order->isDirty('status') && $order->status->value === 'completed') {
            $commission = $order->commissions()->first();
            if ($commission && $commission->status === 'pending') {
                $this->commissionService->autoApproveCommission($commission);
            }
        }

        // If order status changed to delivered, process affiliate commission
        if ($order->isDirty('status') && $order->status === \App\Enums\OrderStatus::Delivered) {
            $this->processDeliveryConfirmation($order);
        }
    }

    /**
     * Process delivery confirmation and affiliate commission
     */
    private function processDeliveryConfirmation(Order $order): void
    {
        // Process affiliate commission if applicable
        if ($order->hasAffiliate() && !$order->commissions()->exists()) {
            $this->commissionService->createCommissionForOrder($order);
        }
    }
}