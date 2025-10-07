<?php

use App\Http\Controllers\HomeController;
use App\Livewire\Form;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('form', Form::class);

Route::redirect('login-redirect', 'login')->name('login');
