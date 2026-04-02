<?php

namespace App\Console\Commands;

use App\Models\Shop\Order;
use Illuminate\Console\Command;

class BackfillOrderPaidAt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:backfill-paid-at {--dry-run : Only show how many orders would be updated}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backfill paid_at for completed orders missing paid_at';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $query = Order::query()
            ->where('payment_status', 'completed')
            ->whereNull('paid_at');

        $total = (clone $query)->count();

        if ($total === 0) {
            $this->info('No orders need backfill.');
            return 0;
        }

        if ($this->option('dry-run')) {
            $this->info("{$total} orders would be updated.");
            return 0;
        }

        $this->info("Updating {$total} orders...");

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $updated = 0;
        $query->orderBy('id')->chunkById(200, function ($orders) use (&$updated, $bar) {
            foreach ($orders as $order) {
                $order->update([
                    'paid_at' => $order->delivered_at ?? now(),
                ]);
                $updated++;
                $bar->advance();
            }
        });

        $bar->finish();
        $this->newLine();
        $this->info("Done. Updated {$updated} orders.");

        return 0;
    }
}
