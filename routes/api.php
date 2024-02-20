<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\InvoiceActionController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\TableController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Controller; 
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

use App\Models\Item;
use App\Models\ItemCategory;

Route::post('/update-image', function () {
    $categories = ItemCategory::all();

    // Iterate over each category
    foreach ($categories as $category) {
        // Check if the 'image' column exists in the category
        if ($category->image) {
            // If the 'image' column exists, remove 'ItemCategory\' from the beginning of the image path
            $category->image = str_replace('ItemCategory\\', '', $category->image);
            // Save the updated category
            $category->save();
        }
    }

    $items = Item::all();
    
    // Iterate over each item
    foreach ($items as $item) {
        // Check if the 'image' column exists in the item
        if ($item->image) {
            // If the 'image' column exists, remove 'Item\\' from the beginning of the image path
            $item->image = str_replace('Item\\', '', $item->image);
            // Save the updated item
            $item->save();
        }
    }

    return response()->json(['message' => 'Item image paths updated successfully']);
});

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    // Items
    Route::resource('items', ItemController::class)->only(['index']);

    // Items
    Route::resource('tables', TableController::class)->only(['index']);

    // Items
    Route::resource('employees', EmployeeController::class)->only(['index']);

    // Invoices
    Route::resource('invoices', InvoiceController::class)->only(['store']);
    Route::put('invoices/{local_invoice}', [InvoiceController::class, 'update']);

    Route::post('invoices/migrate', [InvoiceActionController::class, 'migrate']);
    Route::post('invoices/separate', [InvoiceActionController::class, 'separate']);
    Route::post('invoices/move', [InvoiceActionController::class, 'move']);
    
    // Orders
    Route::resource('orders', OrderController::class)->only(['store']);
    Route::put('orders/{local_invoice}', [OrderController::class, 'update']);
    Route::delete('orders/{local_invoice}', [OrderController::class, 'destroy']);

    // Payments
    Route::resource('payments', PaymentController::class)->only(['store']);
});
