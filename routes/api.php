<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;


Route::post('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('report/accounting', [\App\Http\Controllers\AccountingController::class, 'index'])->name('accounting.index');
Route::post('report/orders', [\App\Http\Controllers\OrderController::class, 'report'])->name('orders.report');
Route::post('report/payments', [\App\Http\Controllers\PaymentController::class, 'report'])->name('payments.report');
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'revoke'])->name('revoke');
    Route::post('order', [\App\Http\Controllers\OrderController::class, 'order'])->name('book.order');
    Route::post('payment', [\App\Http\Controllers\PaymentController::class, 'payment'])->name('book.payment');
    Route::middleware('log')->group(function () {
        Route::get('/books', [BookController::class, 'index'])->name('book.index');
    });
});

