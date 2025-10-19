<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Shop\Order;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;

class TestOrderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:order-email {email} {--order-id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test order confirmation email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $orderId = $this->option('order-id');

        try {
            // Get order
            if ($orderId) {
                $order = Order::with(['items.product', 'user'])->findOrFail($orderId);
            } else {
                $order = Order::with(['items.product', 'user'])->latest()->first();
                
                if (!$order) {
                    $this->error('No orders found in database. Please create an order first.');
                    return 1;
                }
            }

            $this->info("Sending test email to: {$email}");
            $this->info("Using order: #{$order->order_number} (ID: {$order->id})");

            // Send email
            Mail::to($email)->send(new OrderConfirmationMail($order));

            $this->info('✅ Email sent successfully!');
            $this->info('Check your email inbox for the order confirmation.');

        } catch (\Exception $e) {
            $this->error('❌ Failed to send email: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
