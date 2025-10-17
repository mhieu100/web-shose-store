<?php

namespace App\Http\Controllers;

use App\Models\AffiliateLink;
use App\Models\Shop\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class AffiliateController extends Controller
{
    /**
     * Show affiliate dashboard for CTV
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        
        if (!$user->isActiveAffiliate()) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        $affiliateLinks = $user->affiliateLinks()->with('product')->paginate(10);
        $commissions = $user->commissions()->with(['order', 'product'])->latest()->paginate(10);
        
        $stats = [
            'total_links' => $user->affiliateLinks()->count(),
            'total_clicks' => $user->affiliateLinks()->sum('clicks'),
            'total_conversions' => $user->affiliateLinks()->sum('conversions'),
            'pending_commission' => $user->getTotalPendingCommissions(),
            'approved_commission' => $user->getTotalApprovedCommissions(),
            'paid_commission' => $user->getTotalPaidCommissions(),
        ];

        return view('affiliate.dashboard', compact('affiliateLinks', 'commissions', 'stats'));
    }

    /**
     * Create affiliate link for a product
     */
    public function createLink(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:shop_products,id'
        ]);

        $user = Auth::user();
        
        if (!$user->isActiveAffiliate()) {
            return response()->json(['error' => 'Bạn không có quyền tạo link affiliate.'], 403);
        }

        $affiliateLink = $user->createAffiliateLink($request->product_id);
        
        if (!$affiliateLink) {
            return response()->json(['error' => 'Không thể tạo link affiliate.'], 400);
        }

        return response()->json([
            'success' => true,
            'link' => $affiliateLink->affiliate_url,
            'link_code' => $affiliateLink->link_code,
        ]);
    }

    /**
     * Get affiliate link for a product
     */
    public function getLink(Product $product): JsonResponse
    {
        $user = Auth::user();
        
        if (!$user->isActiveAffiliate()) {
            return response()->json(['error' => 'Bạn không có quyền truy cập.'], 403);
        }

        $affiliateLink = $user->affiliateLinks()->where('shop_product_id', $product->id)->first();
        
        if (!$affiliateLink) {
            // Create new link if doesn't exist
            $affiliateLink = $user->createAffiliateLink($product->id);
        }

        if (!$affiliateLink) {
            return response()->json(['error' => 'Không thể tạo link affiliate.'], 400);
        }

        return response()->json([
            'success' => true,
            'link' => $affiliateLink->affiliate_url,
            'link_code' => $affiliateLink->link_code,
            'clicks' => $affiliateLink->clicks,
            'conversions' => $affiliateLink->conversions,
        ]);
    }

    /**
     * Show all products for affiliate selection
     */
    public function products(Request $request): View
    {
        $user = Auth::user();
        
        if (!$user->isActiveAffiliate()) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        $query = Product::where('is_visible', true);

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('category')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('shop_category_id', $request->get('category'));
            });
        }

        $products = $query->with(['categories', 'brand'])->paginate(12);

        // Get existing affiliate links for these products
        $productIds = $products->pluck('id');
        $existingLinks = $user->affiliateLinks()
                             ->whereIn('shop_product_id', $productIds)
                             ->get()
                             ->keyBy('shop_product_id');

        return view('affiliate.products', compact('products', 'existingLinks'));
    }

    /**
     * Toggle affiliate link status
     */
    public function toggleLink(AffiliateLink $affiliateLink): JsonResponse
    {
        if ($affiliateLink->user_id !== Auth::id()) {
            return response()->json(['error' => 'Không có quyền thao tác.'], 403);
        }

        $affiliateLink->update(['is_active' => !$affiliateLink->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $affiliateLink->is_active,
        ]);
    }

    /**
     * Get affiliate statistics
     */
    public function stats(): JsonResponse
    {
        $user = Auth::user();
        
        if (!$user->isActiveAffiliate()) {
            return response()->json(['error' => 'Bạn không có quyền truy cập.'], 403);
        }

        $stats = [
            'total_links' => $user->affiliateLinks()->count(),
            'active_links' => $user->affiliateLinks()->where('is_active', true)->count(),
            'total_clicks' => $user->affiliateLinks()->sum('clicks'),
            'total_conversions' => $user->affiliateLinks()->sum('conversions'),
            'conversion_rate' => $user->affiliateLinks()->sum('clicks') > 0 
                ? round(($user->affiliateLinks()->sum('conversions') / $user->affiliateLinks()->sum('clicks')) * 100, 2)
                : 0,
            'pending_commission' => $user->getTotalPendingCommissions(),
            'approved_commission' => $user->getTotalApprovedCommissions(),
            'paid_commission' => $user->getTotalPaidCommissions(),
            'total_commission' => $user->commissions()->sum('commission_amount'),
        ];

        return response()->json($stats);
    }
}