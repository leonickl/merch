<?php

use App\Controllers\ItemController;
use App\Controllers\LoginController;
use App\Controllers\MainController;
use App\Controllers\MerchController;
use App\Controllers\OrderController;
use App\Controllers\RegisterController;
use App\Controllers\UserController;
use App\Controllers\VerificationController;
use App\Middleware\RequireAdmin;
use App\Middleware\RequireOrga;
use PXP\Http\Controllers\AssetController;
use PXP\Http\Middleware\InteractiveAuth;
use PXP\Router\Route;

Route::get('/')->do(MainController::class, 'index')->name('main');

Route::group(
    Route::get('/merchs')->do(MerchController::class, 'index')->name('merchs.index'),
    Route::get('/merchs/create')->do(MerchController::class, 'create')->name('merchs.create'),
    Route::post('/merchs')->do(MerchController::class, 'store')->name('merchs.store'),
    Route::post('/merchs/{id}/status')->do(MerchController::class, 'setStatus')->name('merchs.set-status'),
)
    ->middleware(InteractiveAuth::class)
    ->middleware(RequireOrga::class);

Route::group(
    Route::get('/orders')->do(OrderController::class, 'index')->name('orders.index'),
    Route::get('/orders/create')->do(OrderController::class, 'create')->name('orders.create'),
    Route::post('/orders')->do(OrderController::class, 'store')->name('orders.store'),
    Route::post('/orders/{id}/status')->do(OrderController::class, 'setStatus')->name('orders.set-status'),
    Route::get('/orders/{id}/items')->do(OrderController::class, 'items')->name('orders.items'),
)
    ->middleware(InteractiveAuth::class)
    ->middleware(RequireOrga::class);

Route::group(
    Route::get('/users')->do(UserController::class, 'index')->name('users.index'),
    Route::get('/users/create')->do(UserController::class, 'create')->name('users.create'),
    Route::post('/users')->do(UserController::class, 'store')->name('users.store'),
)
    ->middleware(InteractiveAuth::class)
    ->middleware(RequireAdmin::class);

Route::group(
    Route::get('/orders/{id}/items/create')->do(ItemController::class, 'create')->name('items.create'),
    Route::post('/orders/{id}/items')->do(ItemController::class, 'store')->name('items.store'),
)
    ->middleware(InteractiveAuth::class);

Route::group(
    Route::get('/verify')->do(VerificationController::class, 'verify')->name('verify'),
);

Route::group(
    Route::get('/register')->do(RegisterController::class, 'form')->name('register'),
    Route::post('/register')->do(RegisterController::class, 'register'),
);

Route::group(
    Route::get('/login')->do(LoginController::class, 'form')->name('login'),
    Route::post('/login')->do(LoginController::class, 'login'),
);

Route::group(
    Route::get('/logout')->do(LoginController::class, 'logout')->name('logout'),
    Route::post('/logout')->do(LoginController::class, 'logout'),
)
    ->middleware(InteractiveAuth::class);

Route::group(
    Route::get('/css/{file}')->do(AssetController::class, 'css')->name('css'),
);
