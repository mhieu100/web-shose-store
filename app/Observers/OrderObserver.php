<?php

namespace App\Observers;

use App\Models\Shop\Order;
use App\Services\CommissionService;

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