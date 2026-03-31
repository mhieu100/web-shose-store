<?php

namespace App\Filament\Widgets;

use App\Models\CollaboratorApplication;
use App\Models\Commission;
use App\Models\AffiliateLink;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class CtvStatsWidget extends BaseWidget
{
    protected bool $useMockData = true;

    protected function getStats(): array
    {
        if ($this->useMockData) {
            $stats = [
                'totalCtvs' => 8,
                'activeCtvs' => 5,
                'pendingApplications' => 1,
                'totalCommissions' => 20000,
                'pendingCommissions' => 20000,
                'paidCommissions' => 0,
                'totalAffiliateLinks' => 0,
                'totalClicks' => 0,
                'totalConversions' => 0,
                'conversionRate' => 0,
            ];
        } else {
            // Real query logic kept for later use.
            $stats = Cache::remember('admin_ctv_stats_widget', 60, function (): array {
                $totalCtvs = User::byRole('ctv')->count();
                $activeCtvs = User::byRole('ctv')->where('is_affiliate_active', true)->count();
                $pendingApplications = CollaboratorApplication::where('status', 'pending')->count();

                $totalCommissions = Commission::sum('commission_amount');
                $pendingCommissions = Commission::where('status', 'pending')->sum('commission_amount');
                $paidCommissions = Commission::where('status', 'paid')->sum('commission_amount');

                $totalAffiliateLinks = AffiliateLink::count();
                $totalClicks = AffiliateLink::sum('clicks');
                $totalConversions = AffiliateLink::sum('conversions');

                $conversionRate = $totalClicks > 0 ? round(($totalConversions / $totalClicks) * 100, 2) : 0;

                return [
                    'totalCtvs' => $totalCtvs,
                    'activeCtvs' => $activeCtvs,
                    'pendingApplications' => $pendingApplications,
                    'totalCommissions' => $totalCommissions,
                    'pendingCommissions' => $pendingCommissions,
                    'paidCommissions' => $paidCommissions,
                    'totalAffiliateLinks' => $totalAffiliateLinks,
                    'totalClicks' => $totalClicks,
                    'totalConversions' => $totalConversions,
                    'conversionRate' => $conversionRate,
                ];
            });
        }

        return [
            Stat::make('Tổng CTV', $stats['totalCtvs'])
                ->description('Tổng số cộng tác viên')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
                
            Stat::make('CTV Hoạt động', $stats['activeCtvs'])
                ->description('CTV đang hoạt động')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
                
            Stat::make('Đơn chờ duyệt', $stats['pendingApplications'])
                ->description('Đơn đăng ký CTV chờ duyệt')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
                
            Stat::make('Tổng hoa hồng', number_format($stats['totalCommissions']) . 'đ')
                ->description('Tổng hoa hồng đã tạo')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
                
            Stat::make('HH chờ thanh toán', number_format($stats['pendingCommissions']) . 'đ')
                ->description('Hoa hồng chờ thanh toán')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning'),
                
            Stat::make('HH đã thanh toán', number_format($stats['paidCommissions']) . 'đ')
                ->description('Hoa hồng đã thanh toán')
                ->descriptionIcon('heroicon-m-check')
                ->color('success'),
                
            Stat::make('Tổng Link Affiliate', number_format($stats['totalAffiliateLinks']))
                ->description('Links affiliate đã tạo')
                ->descriptionIcon('heroicon-m-link')
                ->color('info'),
                
            Stat::make('Tổng Clicks', number_format($stats['totalClicks']))
                ->description('Lượt click affiliate links')
                ->descriptionIcon('heroicon-m-cursor-arrow-rays')
                ->color('info'),
                
            Stat::make('Tỷ lệ chuyển đổi', $stats['conversionRate'] . '%')
                ->description('Tỷ lệ chuyển đổi tổng thể')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($stats['conversionRate'] > 5 ? 'success' : ($stats['conversionRate'] > 2 ? 'warning' : 'danger')),
        ];
    }
    
    protected function getColumns(): int
    {
        return 3;
    }
}