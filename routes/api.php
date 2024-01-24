<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    // Invoices
    Route::resource('invoices', InvoiceController::class)->only(['store', 'update']);
    Route::put('invoices/{local_invoice}', [InvoiceController::class, 'update']);

    // Orders
    Route::resource('orders', OrderController::class)->only(['store']);
    Route::put('orders/{local_invoice}', [OrderController::class, 'update']);
    Route::delete('orders/{local_invoice}', [OrderController::class, 'destroy']);

    // Payments
    Route::resource('payments', PaymentController::class);
});
