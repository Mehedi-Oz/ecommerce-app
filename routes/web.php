<?php

use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\EcommerceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EcommerceController::class, 'index'])->name('home');
Route::get('/products', [EcommerceController::class, 'products'])->name('products');
Route::get('/products/{product}', [EcommerceController::class, 'show'])->name('products.show');

/** cart management routes */
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

/** checkout management routes */
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::get('/checkout/completed', [CheckoutController::class, 'completed'])->name('checkout.completed');
Route::post('/checkout/cash-on-delivery', [CheckoutController::class, 'storeCashOnDelivery'])->name('checkout.cod.store');
Route::post('/checkout/online-payment', [CheckoutController::class, 'storeOnlinePayment'])->name('checkout.online.store');

/** SSLCommerz payment callbacks (POSTed by the gateway, CSRF exempt) */
Route::post('/checkout/payment/success', [CheckoutController::class, 'paymentSuccess'])->name('checkout.payment.success');
Route::post('/checkout/payment/fail', [CheckoutController::class, 'paymentFail'])->name('checkout.payment.fail');
Route::post('/checkout/payment/cancel', [CheckoutController::class, 'paymentCancel'])->name('checkout.payment.cancel');
Route::post('/checkout/payment/ipn', [CheckoutController::class, 'paymentIpn'])->name('checkout.payment.ipn');

Route::middleware('auth')->prefix('dashboard')->group(function () {

    /** Dashboard Management Routes */
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    /** Orders Management Routes */
    Route::get('/orders', [DashboardController::class, 'orders'])->name('dashboard.orders');
    Route::get('/orders/{order}', [DashboardController::class, 'show'])->name('dashboard.orders.show');

    /** User-Profile Management Routes */
    Route::get('/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.profile.update');
    Route::get('/password', [DashboardController::class, 'password'])->name('dashboard.password');
    Route::put('/password', [DashboardController::class, 'updatePassword'])->name('dashboard.password.update');
    Route::get('/profile-photo/{user}', [DashboardController::class, 'photo'])->name('profile.photo');
});
