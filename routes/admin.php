<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FlashDealController;
use App\Http\Controllers\Admin\HeroSliderController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UnitController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /** Profile Management Routes */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/password', [ProfileController::class, 'editPassword'])->name('password.edit');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    /** Categories Management Routes */
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::patch('/categories/{category}/status', [CategoryController::class, 'toggleStatus'])->name('categories.status');
    Route::patch('/categories/{category}/featured', [CategoryController::class, 'toggleFeatured'])->name('categories.featured');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    /** SubCategories Management Routes */
    Route::get('/subcategories', [SubCategoryController::class, 'index'])->name('subcategories.index');
    Route::get('/subcategories/create', [SubCategoryController::class, 'create'])->name('subcategories.create');
    Route::post('/subcategories', [SubCategoryController::class, 'store'])->name('subcategories.store');
    Route::get('/subcategories/{subcategory}/edit', [SubCategoryController::class, 'edit'])->name('subcategories.edit');
    Route::put('/subcategories/{subcategory}', [SubCategoryController::class, 'update'])->name('subcategories.update');
    Route::patch('/subcategories/{subcategory}/status', [SubCategoryController::class, 'toggleStatus'])->name('subcategories.status');
    Route::delete('/subcategories/{subcategory}', [SubCategoryController::class, 'destroy'])->name('subcategories.destroy');

    /** Brands Management Routes */
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
    Route::patch('/brands/{brand}/status', [BrandController::class, 'toggleStatus'])->name('brands.status');
    Route::patch('/brands/{brand}/featured', [BrandController::class, 'toggleFeatured'])->name('brands.featured');
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');

    /** Units Management Routes */
    Route::get('/units', [UnitController::class, 'index'])->name('units.index');
    Route::get('/units/create', [UnitController::class, 'create'])->name('units.create');
    Route::post('/units', [UnitController::class, 'store'])->name('units.store');
    Route::get('/units/{unit}/edit', [UnitController::class, 'edit'])->name('units.edit');
    Route::put('/units/{unit}', [UnitController::class, 'update'])->name('units.update');
    Route::patch('/units/{unit}/status', [UnitController::class, 'toggleStatus'])->name('units.status');
    Route::delete('/units/{unit}', [UnitController::class, 'destroy'])->name('units.destroy');

    /** Products Management Routes */
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::patch('/products/{product}/status', [ProductController::class, 'toggleStatus'])->name('products.status');
    Route::patch('/products/{product}/featured', [ProductController::class, 'toggleFeatured'])->name('products.featured');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    /** Orders Management Routes */
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    /** Hero Sliders Management Routes */
    Route::get('/hero-sliders', [HeroSliderController::class, 'index'])->name('hero-sliders.index');
    Route::get('/hero-sliders/create', [HeroSliderController::class, 'create'])->name('hero-sliders.create');
    Route::post('/hero-sliders', [HeroSliderController::class, 'store'])->name('hero-sliders.store');
    Route::get('/hero-sliders/{heroSlider}/edit', [HeroSliderController::class, 'edit'])->name('hero-sliders.edit');
    Route::put('/hero-sliders/{heroSlider}', [HeroSliderController::class, 'update'])->name('hero-sliders.update');
    Route::patch('/hero-sliders/{heroSlider}/status', [HeroSliderController::class, 'toggleStatus'])->name('hero-sliders.status');
    Route::delete('/hero-sliders/{heroSlider}', [HeroSliderController::class, 'destroy'])->name('hero-sliders.destroy');

    /** Banners Management Routes */
    Route::get('/banners', [BannerController::class, 'index'])->name('banners.index');
    Route::get('/banners/create', [BannerController::class, 'create'])->name('banners.create');
    Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
    Route::get('/banners/{banner}/edit', [BannerController::class, 'edit'])->name('banners.edit');
    Route::put('/banners/{banner}', [BannerController::class, 'update'])->name('banners.update');
    Route::patch('/banners/{banner}/status', [BannerController::class, 'toggleStatus'])->name('banners.status');
    Route::delete('/banners/{banner}', [BannerController::class, 'destroy'])->name('banners.destroy');

    /** Flash Deals Management Routes */
    Route::get('/flash-deals', [FlashDealController::class, 'index'])->name('flash-deals.index');
    Route::get('/flash-deals/create', [FlashDealController::class, 'create'])->name('flash-deals.create');
    Route::post('/flash-deals', [FlashDealController::class, 'store'])->name('flash-deals.store');
    Route::get('/flash-deals/{flashDeal}/edit', [FlashDealController::class, 'edit'])->name('flash-deals.edit');
    Route::put('/flash-deals/{flashDeal}', [FlashDealController::class, 'update'])->name('flash-deals.update');
    Route::patch('/flash-deals/{flashDeal}/status', [FlashDealController::class, 'toggleStatus'])->name('flash-deals.status');
    Route::delete('/flash-deals/{flashDeal}', [FlashDealController::class, 'destroy'])->name('flash-deals.destroy');
});
