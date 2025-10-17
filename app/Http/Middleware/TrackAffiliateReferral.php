<?php

namespace App\Http\Middleware;

use App\Models\AffiliateLink;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackAffiliateReferral
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check for affiliate referral code in URL
        if ($request->has('ref')) {
            $affiliateCode = $request->get('ref');
            
            // Find the affiliate user
            $affiliateUser = User::where('affiliate_code', $affiliateCode)
                                ->where('is_affiliate_active', true)
                                ->first();
            
            if ($affiliateUser) {
                // Store affiliate information in session
                session([
                    'affiliate_user_id' => $affiliateUser->id,
                    'affiliate_code' => $affiliateCode,
                    'affiliate_referral_time' => now(),
                ]);

                // If this is a product page, track the click
                if ($request->route()->getName() === 'product.show') {
                    $productId = $request->route('id');
                    $affiliateLink = AffiliateLink::where('user_id', $affiliateUser->id)
                                                  ->where('shop_product_id', $productId)
                                                  ->first();
                    
                    if ($affiliateLink) {
                        $affiliateLink->recordClick();
                        session(['affiliate_link_code' => $affiliateLink->link_code]);
                    }
                }
            }
        }

        return $next($request);
    }
}