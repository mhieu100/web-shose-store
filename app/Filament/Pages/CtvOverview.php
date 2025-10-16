<?php

namespace App\Filament\Pages;

use App\Models\CollaboratorApplication;
use App\Models\Commission;
use App\Models\AffiliateLink;
use App\Models\User;
use Filament\Pages\Page;
use UnitEnum;
use BackedEnum;

class CtvOverview extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-presentation-chart-line';
    
    protected static ?string $navigationLabel = 'Tổng Quan CTV';
    
    protected static string|UnitEnum|null $navigationGroup = 'Quản lý CTV';
    
    protected static ?int $navigationSort = 1;
    
    protected string $view = 'filament.pages.ctv-overview';
    
    public function getData(): array
    {
        // CTV Stats
        $totalCtvs = User::byRole('ctv')->count();
        $activeCtvs = User::byRole('ctv')->where('is_affiliate_active', true)->count();
        $inactiveCtvs = $totalCtvs - $activeCtvs;
        
        // Applications
        $pendingApplications = CollaboratorApplication::where('status', 'pending')->count();
        $approvedApplications = CollaboratorApplication::where('status', 'approved')->count();
        $rejectedApplications = CollaboratorApplication::where('status', 'rejected')->count();
        
        // Commissions
        $totalCommissions = Commission::sum('commission_amount');
        $pendingCommissions = Commission::where('status', 'pending')->sum('commission_amount');
        $approvedCommissions = Commission::where('status', 'approved')->sum('commission_amount');
        $paidCommissions = Commission::where('status', 'paid')->sum('commission_amount');
        
        // Affiliate Links
        $totalLinks = AffiliateLink::count();
        $activeLinks = AffiliateLink::where('is_active', true)->count();
        $totalClicks = AffiliateLink::sum('clicks');
        $totalConversions = AffiliateLink::sum('conversions');
        
        // Performance
        $conversionRate = $totalClicks > 0 ? round(($totalConversions / $totalClicks) * 100, 2) : 0;
        $avgCommissionPerCtv = $activeCtvs > 0 ? round($totalCommissions / $activeCtvs, 0) : 0;
        
        // Top CTVs
        $topCtvs = User::byRole('ctv')
            ->where('is_affiliate_active', true)
            ->withSum('commissions', 'commission_amount')
            ->withSum('affiliateLinks', 'clicks')
            ->withSum('affiliateLinks', 'conversions')
            ->orderBy('commissions_sum_commission_amount', 'desc')
            ->limit(10)
            ->get();
            
        // Recent Activities
        $recentCommissions = Commission::with(['user', 'order'])
            ->latest()
            ->limit(10)
            ->get();
            
        $recentApplications = CollaboratorApplication::with('user')
            ->latest()
            ->limit(5)
            ->get();

        return [
            'ctv_stats' => [
                'total' => $totalCtvs,
                'active' => $activeCtvs,
                'inactive' => $inactiveCtvs,
            ],
            'applications' => [
                'pending' => $pendingApplications,
                'approved' => $approvedApplications,
                'rejected' => $rejectedApplications,
            ],
            'commissions' => [
                'total' => $totalCommissions,
                'pending' => $pendingCommissions,
                'approved' => $approvedCommissions,
                'paid' => $paidCommissions,
            ],
            'links' => [
                'total' => $totalLinks,
                'active' => $activeLinks,
                'clicks' => $totalClicks,
                'conversions' => $totalConversions,
            ],
            'performance' => [
                'conversion_rate' => $conversionRate,
                'avg_commission_per_ctv' => $avgCommissionPerCtv,
            ],
            'top_ctvs' => $topCtvs,
            'recent_commissions' => $recentCommissions,
            'recent_applications' => $recentApplications,
        ];
    }
}