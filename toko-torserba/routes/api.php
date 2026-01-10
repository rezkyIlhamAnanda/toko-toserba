<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MidtransCallbackController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/checkout/callback', [CheckoutController::class, 'callback']);
Route::post('/midtrans/callback', [MidtransCallbackController::class, 'callback']);
Route::get('/midtrans/check-status/{orderId}', [MidtransCallbackController::class, 'checkStatus']);

