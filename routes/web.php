<?php

use App\Http\Controllers\HomeController;
use App\Livewire\Form;
use Illuminate\Support\Facades\Route;



// Frontend routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop routes
Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop');
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
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'store'])->name('cart.add');
Route::put('/cart/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [App\Http\Controllers\CartController::class, 'destroy'])->name('cart.remove');
Route::delete('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [App\Http\Controllers\CartController::class, 'count'])->name('cart.count');
Route::get('/cart/sidebar-content', [App\Http\Controllers\CartController::class, 'getSidebarContent'])->name('cart.sidebar-content');
// Checkout routes
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::post('/checkout/apply-coupon', [App\Http\Controllers\CheckoutController::class, 'applyCoupon'])->name('checkout.apply_coupon');
    Route::delete('/checkout/remove-coupon', [App\Http\Controllers\CheckoutController::class, 'removeCoupon'])->name('checkout.remove_coupon');
    Route::get('/order/confirmation/{order}', [App\Http\Controllers\CheckoutController::class, 'confirmation'])->name('order.confirmation');
});
Route::get('/compare', function() { return view('compare.index'); })->name('compare');

// Wishlist routes
Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist');
Route::post('/wishlist/add', [App\Http\Controllers\WishlistController::class, 'store'])->name('wishlist.add');
Route::delete('/wishlist/remove', [App\Http\Controllers\WishlistController::class, 'destroy'])->name('wishlist.remove');
Route::post('/wishlist/toggle', [App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::delete('/wishlist/clear', [App\Http\Controllers\WishlistController::class, 'clear'])->name('wishlist.clear');
Route::get('/wishlist/count', [App\Http\Controllers\WishlistController::class, 'count'])->name('wishlist.count');

// Test route for wishlist modal
Route::get('/test-wishlist-modal', function() { 
    return view('test-wishlist-modal'); 
})->name('test.wishlist.modal');

// Blog routes
Route::get('/blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog');
Route::get('/blog/left-sidebar', [App\Http\Controllers\BlogController::class, 'leftSidebar'])->name('blog.left-sidebar');
Route::get('/blog/right-sidebar', [App\Http\Controllers\BlogController::class, 'rightSidebar'])->name('blog.right-sidebar');
Route::get('/blog/details/{slug?}', [App\Http\Controllers\BlogController::class, 'details'])->name('blog.details');
Route::get('/blog/details-left/{slug?}', [App\Http\Controllers\BlogController::class, 'detailsLeft'])->name('blog.details-left');
Route::get('/blog/details-right/{slug?}', [App\Http\Controllers\BlogController::class, 'detailsRight'])->name('blog.details-right');

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
Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
});

Route::get('form', Form::class);

// Test auth status page (temporary)
Route::get('/auth-status', function() {
    return view('auth-status');
});

// Collaborator routes
Route::get('/dang-ky-cong-tac-vien', [App\Http\Controllers\CollaboratorController::class, 'showForm'])->name('collaborator.register');
Route::post('/dang-ky-cong-tac-vien', [App\Http\Controllers\CollaboratorController::class, 'store'])->name('collaborator.store');
Route::get('/trang-thai-cong-tac-vien', [App\Http\Controllers\CollaboratorController::class, 'status'])->name('collaborator.status');

// Affiliate routes - only for authenticated CTVs
Route::middleware(['auth'])->prefix('affiliate')->name('affiliate.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AffiliateController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [App\Http\Controllers\AffiliateController::class, 'products'])->name('products');
    Route::get('/guide', function() {
        return view('affiliate.guide');
    })->name('guide');
    Route::post('/create-link', [App\Http\Controllers\AffiliateController::class, 'createLink'])->name('create-link');
    Route::get('/get-link/{product}', [App\Http\Controllers\AffiliateController::class, 'getLink'])->name('get-link');
    Route::post('/toggle-link/{affiliateLink}', [App\Http\Controllers\AffiliateController::class, 'toggleLink'])->name('toggle-link');
    Route::get('/stats', [App\Http\Controllers\AffiliateController::class, 'stats'])->name('stats');
});

// Invoice routes - chỉ admin mới được in hóa đơn
Route::middleware(['auth', 'admin.only'])->group(function () {
    Route::get('/invoice/{order}/download', [\App\Http\Controllers\InvoiceController::class, 'downloadInvoice'])->name('invoice.download');
    Route::get('/invoice/{order}/view', [\App\Http\Controllers\InvoiceController::class, 'viewInvoice'])->name('invoice.view');
});

