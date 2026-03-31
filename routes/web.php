<?php

use App\Http\Controllers\HomeController;
use App\Livewire\Form;
use Illuminate\Support\Facades\Route;



// Frontend routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop routes
Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop');
Route::get('/shop/search', [App\Http\Controllers\ShopController::class, 'search'])->name('shop.search');
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
Route::get('/cart/count', [App\Http\Controllers\CartController::class, 'count'])->name('cart.count');
Route::get('/cart/sidebar-content', [App\Http\Controllers\CartController::class, 'getSidebarContent'])->name('cart.sidebar-content');

// Cart actions requiring authentication
Route::middleware(['auth', 'no.cache'])->group(function () {
    Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'store'])->name('cart.add');
    Route::put('/cart/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/increment', [App\Http\Controllers\CartController::class, 'increment'])->name('cart.increment');
    Route::post('/cart/decrement', [App\Http\Controllers\CartController::class, 'decrement'])->name('cart.decrement');
    Route::delete('/cart/remove', [App\Http\Controllers\CartController::class, 'destroy'])->name('cart.remove');
    Route::delete('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
    Route::post('/cart/coupon', [App\Http\Controllers\CartController::class, 'applyCoupon'])->name('cart.coupon');
    Route::delete('/cart/coupon', [App\Http\Controllers\CartController::class, 'removeCoupon'])->name('cart.coupon.remove');
});
// Checkout routes
Route::middleware(['auth', 'no.cache'])->group(function () {
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::post('/checkout/apply-coupon', [App\Http\Controllers\CheckoutController::class, 'applyCoupon'])->name('checkout.apply_coupon');
    Route::delete('/checkout/remove-coupon', [App\Http\Controllers\CheckoutController::class, 'removeCoupon'])->name('checkout.remove_coupon');
    Route::get('/order/confirmation/{order}', [App\Http\Controllers\CheckoutController::class, 'confirmation'])->name('order.confirmation');

    // PayPal payment routes
    // Accept both GET (from redirects) and POST (from forms) for createPayment to avoid method mismatch
    Route::post('/paypal/payment/{order}', [App\Http\Controllers\PayPalController::class, 'createPayment'])->name('paypal.payment');
    Route::get('/paypal/payment/{order}', [App\Http\Controllers\PayPalController::class, 'createPayment']);
    Route::get('/paypal/success', [App\Http\Controllers\PayPalController::class, 'success'])->name('paypal.success');
    Route::get('/paypal/cancel', [App\Http\Controllers\PayPalController::class, 'cancel'])->name('paypal.cancel');
});

// PayPal webhook (no auth required)
Route::post('/paypal/webhook', [App\Http\Controllers\PayPalController::class, 'webhook'])->name('paypal.webhook');
Route::get('/compare', function() { return view('compare.index'); })->name('compare');

// Wishlist routes
Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist');
Route::get('/wishlist/count', [App\Http\Controllers\WishlistController::class, 'count'])->name('wishlist.count');

// Wishlist actions requiring authentication
Route::middleware(['auth', 'no.cache'])->group(function () {
    Route::post('/wishlist/add', [App\Http\Controllers\WishlistController::class, 'store'])->name('wishlist.add');
    Route::delete('/wishlist/remove', [App\Http\Controllers\WishlistController::class, 'destroy'])->name('wishlist.remove');
    Route::post('/wishlist/toggle', [App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/clear', [App\Http\Controllers\WishlistController::class, 'clear'])->name('wishlist.clear');
});

// Test route for wishlist modal
Route::get('/test-wishlist-modal', function() {
    return view('test-wishlist-modal');
})->name('test.wishlist.modal');

// Test route for toast notifications (Toastify JS)
Route::get('/test-toast', function() {
    return view('test-toast');
})->name('test.toast');

// Blog routes
Route::get('/blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog');
Route::get('/blog/left-sidebar', [App\Http\Controllers\BlogController::class, 'leftSidebar'])->name('blog.left-sidebar');
Route::get('/blog/right-sidebar', [App\Http\Controllers\BlogController::class, 'rightSidebar'])->name('blog.right-sidebar');
Route::get('/blog/details/{slug?}', [App\Http\Controllers\BlogController::class, 'details'])->name('blog.details');
Route::get('/blog/details-left/{slug?}', [App\Http\Controllers\BlogController::class, 'detailsLeft'])->name('blog.details-left');
Route::get('/blog/details-right/{slug?}', [App\Http\Controllers\BlogController::class, 'detailsRight'])->name('blog.details-right');

// Other pages
Route::get('/about', [App\Http\Controllers\AboutController::class, 'index'])->name('about');
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.send');

// CSRF token refresh route
Route::get('/csrf-token', function() {
    return response()->json(['token' => csrf_token()]);
});


// Account routes - require authentication
Route::middleware(['auth', 'no.cache'])->prefix('account')->name('account.')->group(function () {
    Route::get('/', [App\Http\Controllers\AccountController::class, 'index'])->name('index');
    Route::put('/profile', [App\Http\Controllers\AccountController::class, 'updateProfile'])->name('update-profile');
    Route::put('/password', [App\Http\Controllers\AccountController::class, 'updatePassword'])->name('update-password');
    Route::get('/orders', [App\Http\Controllers\AccountController::class, 'getOrders'])->name('orders');
    Route::get('/order/{order}', [App\Http\Controllers\AccountController::class, 'showOrder'])->name('order.show');
    Route::post('/order/{order}/cancel', [App\Http\Controllers\AccountController::class, 'cancelOrder'])->name('order.cancel');
    Route::post('/order/{order}/confirm-delivery', [App\Http\Controllers\AccountController::class, 'confirmDelivery'])->name('order.confirm-delivery');

    // Wallet deposit routes
    Route::get('/wallet/deposit', [App\Http\Controllers\AccountController::class, 'showDepositForm'])->name('wallet.deposit');
    Route::post('/wallet/deposit', [App\Http\Controllers\AccountController::class, 'processDeposit'])->name('wallet.deposit.process');
    Route::get('/wallet/deposit/bank-transfer/{deposit}', [App\Http\Controllers\AccountController::class, 'showBankTransferInstructions'])->name('wallet.deposit.bank-transfer');
    Route::post('/wallet/deposit/bank-transfer/{deposit}/confirm', [App\Http\Controllers\AccountController::class, 'confirmBankTransfer'])->name('wallet.deposit.bank-transfer.confirm');
});

// Wallet deposit PayPal routes
Route::middleware('auth')->prefix('wallet/deposit')->name('wallet.deposit.')->group(function () {
    Route::get('/paypal/{deposit}', [App\Http\Controllers\WalletDepositController::class, 'createPayPalPayment'])->name('paypal');
    Route::get('/paypal/{deposit}/success', [App\Http\Controllers\WalletDepositController::class, 'handlePayPalSuccess'])->name('paypal.success');
    Route::get('/paypal/{deposit}/cancel', [App\Http\Controllers\WalletDepositController::class, 'handlePayPalCancel'])->name('paypal.cancel');
});

Route::get('/404', function() { return view('errors.404'); })->name('404');

// Admin routes - chỉ admin mới được truy cập
Route::prefix('admin')->middleware(['auth', 'admin.only', 'no.cache'])->group(function () {
    Route::get('/products', function () {
        return redirect(\App\Filament\Clusters\Products\Resources\Products\ProductResource::getUrl('index'));
    });

    // Filament sẽ tự động handle các routes này
});

// Authentication routes
Route::middleware(['guest', 'no.cache'])->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

    // Forgot Password Routes
    Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware(['auth', 'no.cache'])->group(function () {
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
Route::middleware(['auth', 'no.cache'])->prefix('affiliate')->name('affiliate.')->group(function () {
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
Route::middleware(['auth', 'admin.only', 'no.cache'])->group(function () {
    Route::get('/invoice/{order}/download', [\App\Http\Controllers\InvoiceController::class, 'downloadInvoice'])->name('invoice.download');
    Route::get('/invoice/{order}/view', [\App\Http\Controllers\InvoiceController::class, 'viewInvoice'])->name('invoice.view');
});

// AI Chat Routes
Route::prefix('api/chat')->middleware('web')->group(function () {
    Route::post('/message', [App\Http\Controllers\ChatController::class, 'sendMessage'])->name('chat.message');
    Route::get('/suggestions', [App\Http\Controllers\ChatController::class, 'getQuickSuggestions'])->name('chat.suggestions');
    Route::post('/context', [App\Http\Controllers\ChatController::class, 'getContext'])->name('chat.context');
});

