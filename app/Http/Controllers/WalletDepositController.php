<?php

namespace App\Http\Controllers;

use App\Models\Shop\WalletDeposit;
use App\Services\PayPalService;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WalletDepositController extends Controller
{
    protected PayPalService $paypalService;
    protected WalletService $walletService;

    public function __construct(PayPalService $paypalService, WalletService $walletService)
    {
        $this->middleware('auth');
        $this->paypalService = $paypalService;
        $this->walletService = $walletService;
    }

    /**
     * Create PayPal payment for wallet deposit
     */
    public function createPayPalPayment($depositId)
    {
        $user = Auth::user();
        $deposit = WalletDeposit::where('id', $depositId)
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->firstOrFail();

        try {
            // Create a fake order-like structure for PayPal
            $paymentData = [
                'amount' => $deposit->amount,
                'description' => "Nạp tiền vào ví - " . number_format($deposit->amount) . "₫",
                'return_url' => route('wallet.deposit.paypal.success', $deposit->id),
                'cancel_url' => route('wallet.deposit.paypal.cancel', $deposit->id),
            ];

            $payment = $this->paypalService->createDepositPayment($deposit);

            if (!$payment) {
                throw new \Exception('Failed to create PayPal payment');
            }

            // Store payment data
            $deposit->update([
                'payment_data' => $payment,
            ]);

            // Get approval URL and redirect
            $approvalUrl = $this->paypalService->getApprovalUrl($payment);

            if (!$approvalUrl) {
                throw new \Exception('Failed to get PayPal approval URL');
            }

            return redirect($approvalUrl);

        } catch (\Exception $e) {
            Log::error('PayPal deposit payment creation failed', [
                'deposit_id' => $deposit->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('account.wallet.deposit')
                ->with('error', 'Không thể tạo thanh toán PayPal. Vui lòng thử lại.');
        }
    }

    /**
     * Handle successful PayPal deposit payment
     */
    public function handlePayPalSuccess(Request $request, $depositId)
    {
        $user = Auth::user();
        $deposit = WalletDeposit::where('id', $depositId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $paymentId = $request->get('paymentId');
        $payerId = $request->get('PayerID');

        if (!$paymentId || !$payerId) {
            return redirect()->route('account.wallet.deposit')
                ->with('error', 'Thông tin thanh toán không hợp lệ.');
        }

        DB::beginTransaction();
        try {
            // Execute PayPal payment
            $executedPayment = $this->paypalService->executePayment($paymentId, $payerId);

            if (!$executedPayment || ($executedPayment['state'] ?? '') !== 'approved') {
                throw new \Exception('Payment execution failed');
            }

            // Add funds to wallet
            $wallet = $this->walletService->getOrCreateWallet($user);
            $wallet->addFunds(
                $deposit->amount,
                'deposit',
                "Nạp tiền qua PayPal - Mã giao dịch: {$paymentId}",
                null,
                ['paypal_payment_id' => $paymentId, 'deposit_id' => $deposit->id]
            );

            // Mark deposit as completed
            $deposit->update([
                'status' => 'completed',
                'verified_at' => now(),
                'transaction_reference' => $paymentId,
            ]);

            DB::commit();

            return redirect()->route('account.index')
                ->with('success', 'Nạp tiền thành công! ' . number_format($deposit->amount) . '₫ đã được thêm vào ví của bạn.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('PayPal deposit execution failed', [
                'deposit_id' => $deposit->id,
                'payment_id' => $paymentId,
                'error' => $e->getMessage(),
            ]);

            $deposit->update(['status' => 'failed']);

            return redirect()->route('account.wallet.deposit')
                ->with('error', 'Thanh toán thất bại. Vui lòng thử lại.');
        }
    }

    /**
     * Handle cancelled PayPal deposit payment
     */
    public function handlePayPalCancel($depositId)
    {
        $user = Auth::user();
        $deposit = WalletDeposit::where('id', $depositId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $deposit->update(['status' => 'cancelled']);

        return redirect()->route('account.wallet.deposit')
            ->with('info', 'Bạn đã hủy giao dịch nạp tiền.');
    }
}
