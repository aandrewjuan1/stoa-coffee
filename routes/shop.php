<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Products
Route::get('/products/create', [ProductController::class, 'create'])->middleware('admin')->name('products.create');
Route::get('/products/{product:name}', [ProductController::class, 'show'])->name('products.show');
Route::middleware(['admin'])->group(function () {    
    Route::post('/products', [ProductController::class, 'store'])
        ->name('products.store');
    Route::get('/products/{product:name}/edit', [ProductController::class, 'edit'])
        ->name('products.edit');
    Route::put('/products/{product:name}', [ProductController::class, 'update'])
        ->name('products.update');
    Route::delete('/products/{product:name}', [ProductController::class, 'destroy'])
        ->name('products.destroy');
});

// Cart and Order
Route::middleware('auth')->group(function() {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/order', [OrderController::class, 'order'])->name('order');
});