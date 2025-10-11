<?php

use App\Http\Controllers\HomeController;
use App\Livewire\Form;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

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

