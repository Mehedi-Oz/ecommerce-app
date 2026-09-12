<?php

use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\EcommerceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EcommerceController::class, 'index'])->name('home');
Route::get('/product-category', [EcommerceController::class, 'category'])->name('product-category');
Route::get('/product-details', [EcommerceController::class, 'details'])->name('product-details');

Route::get('/cart/show', [CartController::class, 'index'])->name('cart.show');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
