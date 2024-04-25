<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\ShopsController;
use App\Http\Controllers\SlidesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/admin');
});

Auth::routes();



Route::namespace('Auth')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/register', 'RegisterController@showRegistrationForm')->name('register');
    Route::post('/register', 'RegisterController@register');

    Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/password/reset', 'ResetPasswordController@reset');
});
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');
    Route::resource('products', ProductController::class);
    Route::resource('customers', CustomerController::class);

    //OFFERS
    Route::get('/offers', [OffersController::class, 'index'])->name('offers.index');
    Route::get('/offers/create', [OffersController::class, 'create'])->name('offers.create');
    Route::get('/offers/{offer}/edit', [OffersController::class, 'edit'])->name('offers.edit');
    Route::delete('/offers/{offer}', [OffersController::class, 'destroy'])->name('offers.destroy');
    Route::put('/offers/{offer}', [OffersController::class, 'update'])->name('offers.update');
    Route::post('/offers', [OffersController::class, 'store'])->name('offers.store');


    //SHOP
    Route::get('/shops', [ShopsController::class, 'index'])->name('shops.index');
    Route::get('/shops/create', [ShopsController::class, 'create'])->name('shops.create');
    Route::get('/shops/{shop}/edit', [ShopsController::class, 'edit'])->name('shops.edit');
    Route::delete('/shops/{shop}', [ShopsController::class, 'destroy'])->name('shops.destroy');
    Route::put('/shops/{shop}', [ShopsController::class, 'update'])->name('shops.update');
    Route::post('/shops', [ShopsController::class, 'store'])->name('shops.store');

     //Slide
     Route::get('/slides', [SlidesController::class, 'index'])->name('slides.index');
     Route::get('/slides/create', [SlidesController::class, 'create'])->name('slides.create');
     Route::get('/slides/{slide}/edit', [SlidesController::class, 'edit'])->name('slides.edit');
     Route::delete('/slides/{slide}', [SlidesController::class, 'destroy'])->name('slides.destroy');
     Route::put('/slides/{slide}', [SlidesController::class, 'update'])->name('slides.update');
     Route::post('/slides', [SlidesController::class, 'store'])->name('slides.store');


    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/change-qty', [CartController::class, 'changeQty']);
    Route::delete('/cart/delete', [CartController::class, 'delete']);
    Route::delete('/cart/empty', [CartController::class, 'empty']);
});
