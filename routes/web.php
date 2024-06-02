<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\CartController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/overons', function () {
    return view('pages.overons');
})->name('overons');

Route::get('/community', function () {
    return view('pages.community');
})->name('community');

Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

// Authentication Routes...
Route::get('login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'App\Http\Controllers\Auth\LoginController@login');
Route::post('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::get('register', 'App\Http\Controllers\Auth\RegisterController@showRegisterForm')->name('register');
Route::post('register', 'App\Http\Controllers\Auth\RegisterController@register');

// Admin Routes...
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.home');

    // Admin User Routes
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');

    // Admin Product Routes
    Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/admin/products/{product}', [AdminProductController::class, 'show'])->name('admin.products.show');
    Route::post('/admin/products/{product}/validate', [AdminProductController::class, 'validateProduct'])->name('admin.products.validate');
    Route::post('/admin/products/{product}/invalidate', [AdminProductController::class, 'invalidateProduct'])->name('admin.products.invalidate');
});

// User Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user/products', [ProductController::class, 'manage'])->name('user.products.manage');
    Route::get('/user/products/add', [ProductController::class, 'add'])->name('user.products.add');
    Route::post('/user/products', [ProductController::class, 'store'])->name('user.products.store');
    Route::get('/user/products/{product}/edit', [ProductController::class, 'edit'])->name('user.products.edit');
    Route::put('/user/products/{product}', [ProductController::class, 'update'])->name('user.products.update');
    Route::delete('/user/products/{product}', [ProductController::class, 'destroy'])->name('user.products.destroy');
});

// 2FA Google Routes
Route::get('/google/redirect', [App\Http\Controllers\GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [App\Http\Controllers\GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');

// Category Routes
Route::get('/subcategories', [CategoryController::class, 'getSubcategories'])->name('subcategories');

// Display Products Routes
Route::get('/baby', [CategoryController::class, 'showBabyCategory'])->name('baby');
Route::get('/mama', [CategoryController::class, 'showMamaCategory'])->name('mama');
Route::get('/kind', [CategoryController::class, 'showKindCategory'])->name('kind');

Route::get('/baby/filter', [CategoryController::class, 'filterBabyProducts'])->name('baby.filter');
Route::get('/mama/filter', [CategoryController::class, 'filterMamaProducts'])->name('mama.filter');
Route::get('/kind/filter', [CategoryController::class, 'filterKindProducts'])->name('kind.filter');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// Stripe payment routes
Route::get('/checkout/{product}', [StripeController::class, 'checkout'])->name('checkout');
Route::post('/checkout/{product}', [StripeController::class, 'processPayment'])->name('checkout.process');
Route::get('/payment/success', [StripeController::class, 'paymentSuccess'])->name('payment.success');
