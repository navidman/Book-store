<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('logout', [\App\Http\Controllers\AuthController::class, 'revoke']);
Route::middleware('log')->group(function () {
    Route::get('/books', [BookController::class, 'index']);
});
