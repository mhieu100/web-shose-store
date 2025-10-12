<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $banners = \App\Http\Controllers\BannerController::getHomepageBanners();
        
        return view('home', compact('banners'));
    }
}
