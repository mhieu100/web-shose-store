<?php

use App\Http\Controllers\HomeController;
use App\Livewire\Form;
use Illuminate\Support\Facades\Route;



// Frontend routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop routes
Route::get('/shop', function() { return view('shop.index'); })->name('shop');
Route::get('/shop/search', function() { return view('shop.search'); })->name('shop.search');
Route::get('/shop/three-columns', function() { return view('shop.three-columns'); })->name('shop.three-columns');
Route::get('/shop/four-columns', function() { return view('shop.four-columns'); })->name('shop.four-columns');
Route::get('/shop/right-sidebar', function() { return view('shop.right-sidebar'); })->name('shop.right-sidebar');

// Product routes
Route::get('/product/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('product.show');
Route::get('/product/normal', function() { return view('product.normal'); })->name('product.normal');
Route::get('/product/variable', function() { return view('product.variable'); })->name('product.variable');
Route::get('/product/group', function() { return view('product.group'); })->name('product.group');
Route::get('/product/affiliate', function() { return view('product.affiliate'); })->name('product.affiliate');

// Cart & Checkout routes
Route::get('/cart', function() { return view('cart.index'); })->name('cart');
Route::get('/checkout', function() { return view('checkout.index'); })->name('checkout');
Route::get('/wishlist', function() { return view('wishlist.index'); })->name('wishlist');
Route::get('/compare', function() { return view('compare.index'); })->name('compare');

// Blog routes
Route::get('/blog', function() { return view('blog.index'); })->name('blog');
Route::get('/blog/left-sidebar', function() { return view('blog.left-sidebar'); })->name('blog.left-sidebar');
Route::get('/blog/right-sidebar', function() { return view('blog.right-sidebar'); })->name('blog.right-sidebar');
Route::get('/blog/details', function() { return view('blog.details'); })->name('blog.details');
Route::get('/blog/details-left', function() { return view('blog.details-left'); })->name('blog.details-left');
Route::get('/blog/details-right', function() { return view('blog.details-right'); })->name('blog.details-right');

// Other pages
Route::get('/about', function() { return view('pages.about'); })->name('about');
Route::get('/contact', function() { return view('pages.contact'); })->name('contact');
Route::get('/account', function() { return view('account.index'); })->name('account');
Route::get('/404', function() { return view('errors.404'); })->name('404');

// Admin routes - chỉ admin mới được truy cập
Route::prefix('admin')->middleware(['auth', 'admin.only'])->group(function () {
    // Filament sẽ tự động handle các routes này
});

// Authentication routes
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('form', Form::class);

// Invoice routes - chỉ admin mới được in hóa đơn
Route::middleware(['auth', 'admin.only'])->group(function () {
    Route::get('/invoice/{order}/download', [\App\Http\Controllers\InvoiceController::class, 'downloadInvoice'])->name('invoice.download');
    Route::get('/invoice/{order}/view', [\App\Http\Controllers\InvoiceController::class, 'viewInvoice'])->name('invoice.view');
});

