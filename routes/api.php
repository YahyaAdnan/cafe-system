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

use App\Models\Item;
use App\Models\ItemCategory;

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

Route::get('/test_ing_price', function () {
    $items = App\Models\Item::all();

    foreach ($items as $key => $item) 
    {
        foreach ($item->prices as $key => $price) 
        {
            foreach ($item->itemIngredients as $key => $itemIngredient) 
            {
                App\Models\IngredientDetails::create([
                    'item_ingredients_id' => $itemIngredient->id,
                    'ingredient_id' => $itemIngredient->ingredient_id,
                    'price_id' => $price->id,
                    'amount' => 0,
                ]);
            }
        }
    }

    dd(App\Models\IngredientDetails::all());
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
    Route::delete('invoices/{local_invoice}', [InvoiceController::class, 'destroy']);

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
