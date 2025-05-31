<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MerchantsController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login',  [AuthController::class, 'create'])->name('auth.create');
Route::post('/login', [AuthController::class, 'store'])->name('auth.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::group([
    'middleware' => [
        'App\Http\Middleware\AuthApi',
    ],
], function () {
    Route::resource('dashboard', DashboardController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('merchants', MerchantsController::class);
});
