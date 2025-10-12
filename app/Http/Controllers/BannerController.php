<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display active banners for homepage
     */
    public function index()
    {
        $banners = Banner::active()
            ->inDateRange()
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($banners->map(function ($banner) {
            return [
                'id' => $banner->id,
                'title' => $banner->title,
                'description' => $banner->description,
                'link_url' => $banner->link_url,
                'image_url' => $banner->image_url,
                'thumb_url' => $banner->thumb_url,
            ];
        }));
    }

    /**
     * Get banners for homepage view
     */
    public static function getHomepageBanners()
    {
        return Banner::active()
            ->inDateRange()
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}