<?php

namespace Database\Seeders;

use App\Models\Commission;
use App\Models\CommissionSetting;
use App\Models\CommissionWithdrawal;
use App\Models\Role;
use App\Models\User;
use App\Models\Shop\Order;
use App\Models\Shop\Product;
use Illuminate\Database\Seeder;

class CommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Tạo cài đặt hoa hồng
        CommissionSetting::updateOrCreate(
            ['type' => 'global'],
            [
                'type' => 'global',
                'commission_rate' => 5.0,
                'min_order_amount' => 100000,
                'max_commission' => 1000000,
                'is_active' => true,
                'priority' => 1,
                'description' => 'Hoa hồng toàn cục 5% cho tất cả CTV'
            ]
        );

        // Tạo setting riêng cho CTV VIP
        $ctvRole = Role::where('name', 'ctv')->first();
        $firstCtv = $ctvRole ? User::where('role_id', $ctvRole->id)->first() : null;
        
        if ($firstCtv) {
            CommissionSetting::updateOrCreate(
                ['type' => 'user', 'target_id' => $firstCtv->id],
                [
                    'type' => 'user',
                    'target_id' => $firstCtv->id,
                    'target_type' => User::class,
                    'commission_rate' => 8.0,
                    'min_order_amount' => 200000,
                    'max_commission' => 2000000,
                    'is_active' => true,
                    'priority' => 2,
                    'description' => 'Hoa hồng VIP 8% cho ' . $firstCtv->name
                ]
            );
        }

        // 2. Tạo hoa hồng cho CTV (chỉ nếu có đơn hàng và sản phẩm)
        $ctvUsers = $ctvRole ? User::where('role_id', $ctvRole->id)->get() : collect();
        $orders = Order::take(10)->get();
        $products = Product::take(5)->get();

        if ($ctvUsers->isNotEmpty() && $orders->isNotEmpty()) {
            foreach ($ctvUsers as $ctv) {
                for ($i = 1; $i <= 3; $i++) {
                    $order = $orders->random();
                    $product = $products->isNotEmpty() ? $products->random() : null;
                    $orderAmount = $order->total_price ?? rand(200000, 1500000);
                    $commissionRate = ($ctv->id === $firstCtv?->id) ? 8.0 : 5.0;
                    $commissionAmount = $orderAmount * ($commissionRate / 100);

                    Commission::create([
                        'user_id' => $ctv->id,
                        'order_id' => $order->id,
                        'product_id' => $product?->id,
                        'order_amount' => $orderAmount,
                        'commission_rate' => $commissionRate,
                        'commission_amount' => $commissionAmount,
                        'status' => collect(['pending', 'approved', 'paid'])->random(),
                        'notes' => 'Hoa hồng từ đơn hàng #' . $order->id . ' cho CTV: ' . $ctv->name,
                        'approved_at' => rand(0, 1) ? now()->subDays(rand(1, 10)) : null,
                        'paid_at' => rand(0, 1) ? now()->subDays(rand(1, 5)) : null,
                    ]);
                }
            }
        }

        // 3. Tạo yêu cầu rút tiền cho CTV
        $adminRole = Role::where('name', 'admin')->first();
        $admin = $adminRole ? User::where('role_id', $adminRole->id)->first() : null;

        foreach ($ctvUsers as $ctv) {
            for ($i = 1; $i <= 2; $i++) {
                $amount = rand(500000, 2000000);
                $fee = round($amount * 0.02); // 2% fee
                $netAmount = $amount - $fee;

                CommissionWithdrawal::create([
                    'withdrawal_code' => CommissionWithdrawal::generateWithdrawalCode(),
                    'user_id' => $ctv->id,
                    'amount' => $amount,
                    'fee' => $fee,
                    'net_amount' => $netAmount,
                    'status' => collect(['pending', 'approved', 'processing', 'completed', 'rejected'])->random(),
                    'payment_method' => collect(['bank_transfer', 'e_wallet'])->random(),
                    'payment_info' => json_encode([
                        'bank_name' => collect(['Vietcombank', 'VietinBank', 'BIDV', 'Techcombank'])->random(),
                        'account_number' => '12345678' . rand(10, 99),
                        'account_name' => $ctv->name
                    ]),
                    'reason' => 'Yêu cầu rút hoa hồng tháng ' . date('m/Y') . ' - ' . $ctv->name,
                    'admin_notes' => collect([null, 'Đã kiểm tra và duyệt', 'Cần bổ sung thông tin', 'Đã chuyển khoản thành công'])->random(),
                    'requested_at' => now()->subDays(rand(1, 30)),
                    'approved_at' => rand(0, 1) ? now()->subDays(rand(1, 15)) : null,
                    'completed_at' => rand(0, 1) ? now()->subDays(rand(1, 7)) : null,
                    'approved_by' => ($admin && rand(0, 1)) ? $admin->id : null,
                ]);
            }
        }

        $this->command->info('✅ Đã tạo thành công dữ liệu commission cho ' . $ctvUsers->count() . ' CTV!');
        $this->command->info('📊 - ' . CommissionSetting::count() . ' cài đặt hoa hồng');
        $this->command->info('💰 - ' . Commission::count() . ' bản ghi hoa hồng');
        $this->command->info('🏦 - ' . CommissionWithdrawal::count() . ' yêu cầu rút tiền');
    }
}