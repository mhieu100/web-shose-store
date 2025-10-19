<?php

namespace App\Http\Controllers;

use App\Models\Shop\Order;
use App\Models\Shop\Payment;
use App\Services\PayPalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayPalController extends Controller
{
    private $paypalService;

    public function __construct(PayPalService $paypalService)
    {
        $this->paypalService = $paypalService;
    }

    /**
     * Redirect to PayPal for payment
     */
    public function createPayment(Request $request, $orderId)
    {
        try {
            $order = Order::where('id', $orderId)
                ->where('user_id', Auth::id())
                ->with(['items.product']) // Eager load items and products
                ->firstOrFail();

            \Log::info('PayPal Payment Creation Started', [
                'order_id' => $orderId,
                'user_id' => Auth::id(),
                'order_total' => $order->total_price
            ]);

            // Check if order can be paid
            if (!$this->canProcessPayment($order)) {
                \Log::warning('Order cannot be processed for payment', ['order_id' => $orderId]);
                return redirect()->route('checkout')
                    ->with('error', 'Đơn hàng này không thể thanh toán.');
            }

            // Validate order data
            if (!$order->items || $order->items->count() === 0) {
                \Log::error('Order has no items', ['order_id' => $orderId]);
                return redirect()->route('checkout')
                    ->with('error', 'Đơn hàng không có sản phẩm.');
            }

            // Create PayPal payment
            $payment = $this->paypalService->createPayment($order);

            if (!$payment) {
                \Log::error('PayPal payment creation failed', ['order_id' => $orderId]);
                return redirect()->route('checkout')
                    ->with('error', 'Không thể tạo thanh toán PayPal. Vui lòng thử lại.');
            }

            // Store payment info
            $this->storePaymentRecord($order, $payment);

            // Get approval URL
            $approvalUrl = $this->paypalService->getApprovalUrl($payment);

            \Log::info('PayPal Payment Created Successfully', [
                'order_id' => $orderId,
                'payment_id' => $payment['id'] ?? 'unknown',
                'approval_url' => $approvalUrl
            ]);

            return redirect($approvalUrl);

        } catch (\Exception $e) {
            \Log::error('PayPal Create Payment Error', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('checkout')
                ->with('error', 'Có lỗi xảy ra khi xử lý thanh toán: ' . $e->getMessage());
        }
    }

    /**
     * Handle successful PayPal payment
     */
    public function success(Request $request)
    {
        try {
            $paymentId = $request->get('paymentId');
            $payerId = $request->get('PayerID');
            $orderId = $request->get('order_id');

            if (!$paymentId || !$payerId || !$orderId) {
                return redirect()->route('checkout')
                    ->with('error', 'Thông tin thanh toán không hợp lệ.');
            }

            // Get order
            $order = Order::where('id', $orderId)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Execute payment
            $result = $this->paypalService->executePayment($paymentId, $payerId);

            if (!$result || ($result['state'] ?? '') !== 'approved') {
                return redirect()->route('checkout')
                    ->with('error', 'Thanh toán PayPal không thành công.');
            }

            // Update payment and order status
            DB::transaction(function () use ($order, $result, $paymentId) {
                // Update payment record
                $payment = \App\Models\Shop\Payment::where('order_id', $order->id)
                    ->where('reference', $paymentId)
                    ->first();

                if ($payment) {
                    $payment->update([
                        'status' => 'completed',
                        'paid_at' => now(),
                        'response_data' => json_encode($result),
                    ]);
                }

                // Update order
                $order->update([
                    'payment_status' => 'completed',
                    'status' => \App\Enums\OrderStatus::Processing,
                    'paid_at' => now(),
                ]);

                // Clear cart and coupon session after successful payment
                \App\Models\Shop\Cart::where('user_id', $order->user_id)->delete();
                session()->forget('applied_coupon_code');
            });

            return redirect()->route('order.confirmation', $order->id)
                ->with('success', 'Thanh toán PayPal thành công!');

        } catch (\Exception $e) {
            \Log::error('PayPal Success Error: ' . $e->getMessage());
            return redirect()->route('checkout')
                ->with('error', 'Có lỗi xảy ra khi xác nhận thanh toán.');
        }
    }

    /**
     * Handle cancelled PayPal payment
     */
    public function cancel(Request $request)
    {
        $orderId = $request->get('order_id');

        if ($orderId) {
            $order = Order::find($orderId);
            if ($order && $order->user_id === Auth::id()) {
                // Update payment record
                \App\Models\Shop\Payment::where('order_id', $order->id)
                    ->where('status', 'pending')
                    ->update(['status' => 'cancelled']);
            }
        }

        return redirect()->route('checkout')
            ->with('error', 'Thanh toán PayPal đã bị hủy.');
    }

    /**
     * Handle PayPal webhooks
     */
    public function webhook(Request $request)
    {
        try {
            $payload = $request->getContent();
            $headers = $request->headers->all();

            // Verify webhook (important for security)
            if (!$this->paypalService->verifyWebhook($headers, $payload)) {
                return response()->json(['error' => 'Invalid webhook'], 400);
            }

            $data = json_decode($payload, true);

            // Handle different webhook events
            switch ($data['event_type']) {
                case 'PAYMENT.SALE.COMPLETED':
                    $this->handlePaymentCompleted($data);
                    break;
                case 'PAYMENT.SALE.DENIED':
                    $this->handlePaymentDenied($data);
                    break;
                // Add more webhook event handlers as needed
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            \Log::error('PayPal Webhook Error: ' . $e->getMessage());
            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }

    /**
     * Check if order can be paid
     */
    private function canProcessPayment(Order $order): bool
    {
        return $order->payment_status !== 'completed' &&
               $order->status !== \App\Enums\OrderStatus::Cancelled;
    }

    /**
     * Store payment record
     */
    private function storePaymentRecord(Order $order, $payment): void
    {
        \App\Models\Shop\Payment::create([
            'order_id' => $order->id,
            'amount' => $order->total_price,
            'currency' => 'VND',
            'method' => 'paypal',
            'status' => 'pending',
            'reference' => $payment['id'],
            'provider' => 'paypal',
            'provider_id' => $payment['id'],
        ]);
    }

    /**
     * Handle completed payment webhook
     */
    private function handlePaymentCompleted(array $data): void
    {
        // Implement webhook handling for completed payments
        \Log::info('PayPal Payment Completed Webhook', $data);
    }

    /**
     * Handle denied payment webhook
     */
    private function handlePaymentDenied(array $data): void
    {
        // Implement webhook handling for denied payments
        \Log::info('PayPal Payment Denied Webhook', $data);
    }
}
