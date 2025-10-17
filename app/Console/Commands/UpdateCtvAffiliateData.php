<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use App\Services\CommissionService;
use Illuminate\Console\Command;

class UpdateCtvAffiliateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ctv:update-affiliate-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update existing CTV users with affiliate codes and activate affiliate features';

    /**
     * Execute the console command.
     */
    public function handle(CommissionService $commissionService)
    {
        $this->info('Đang cập nhật dữ liệu affiliate cho CTV...');

        // Get CTV role
        $ctvRole = Role::where('name', 'ctv')->first();
        
        if (!$ctvRole) {
            $this->error('Không tìm thấy role CTV!');
            return 1;
        }

        // Get all CTV users
        $ctvUsers = User::where('role_id', $ctvRole->id)->get();
        
        $this->info("Tìm thấy {$ctvUsers->count()} CTV users");

        $bar = $this->output->createProgressBar($ctvUsers->count());
        $bar->start();

        $updated = 0;
        foreach ($ctvUsers as $user) {
            // Generate affiliate code if not exists
            if (empty($user->affiliate_code)) {
                $affiliateCode = $commissionService->generateAffiliateCodeForUser($user);
                $this->line("\n✅ Tạo mã affiliate {$affiliateCode} cho user: {$user->name}");
                $updated++;
            } else {
                // Activate existing users
                $user->update(['is_affiliate_active' => true]);
            }
            
            $bar->advance();
        }

        $bar->finish();
        
        $this->info("\n🎉 Đã cập nhật thành công {$updated} CTV users!");
        $this->info("Tất cả CTV users hiện đã có thể sử dụng tính năng affiliate marketing.");

        return 0;
    }
}