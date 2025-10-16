<?php

namespace App\Filament\Widgets;

use App\Models\CollaboratorApplication;
use App\Models\Commission;
use App\Models\AffiliateLink;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CtvStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
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
            Stat::make('Tổng CTV', $totalCtvs)
                ->description('Tổng số cộng tác viên')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
                
            Stat::make('CTV Hoạt động', $activeCtvs)
                ->description('CTV đang hoạt động')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
                
            Stat::make('Đơn chờ duyệt', $pendingApplications)
                ->description('Đơn đăng ký CTV chờ duyệt')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
                
            Stat::make('Tổng hoa hồng', number_format($totalCommissions) . 'đ')
                ->description('Tổng hoa hồng đã tạo')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
                
            Stat::make('HH chờ thanh toán', number_format($pendingCommissions) . 'đ')
                ->description('Hoa hồng chờ thanh toán')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning'),
                
            Stat::make('HH đã thanh toán', number_format($paidCommissions) . 'đ')
                ->description('Hoa hồng đã thanh toán')
                ->descriptionIcon('heroicon-m-check')
                ->color('success'),
                
            Stat::make('Tổng Link Affiliate', number_format($totalAffiliateLinks))
                ->description('Links affiliate đã tạo')
                ->descriptionIcon('heroicon-m-link')
                ->color('info'),
                
            Stat::make('Tổng Clicks', number_format($totalClicks))
                ->description('Lượt click affiliate links')
                ->descriptionIcon('heroicon-m-cursor-arrow-rays')
                ->color('info'),
                
            Stat::make('Tỷ lệ chuyển đổi', $conversionRate . '%')
                ->description('Tỷ lệ chuyển đổi tổng thể')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($conversionRate > 5 ? 'success' : ($conversionRate > 2 ? 'warning' : 'danger')),
        ];
    }
    
    protected function getColumns(): int
    {
        return 3;
    }
}