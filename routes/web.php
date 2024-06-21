<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Navigation
Route::view('/', 'home')->name('home');
Route::view('/about-us', 'about-us')->name('about-us');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::middleware('auth')->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create')
        ->can('create', 'App\\Models\\Product');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store')
        ->can('create', 'App\\Models\\Product');
    Route::get('/products/{product:name}/edit', [ProductController::class, 'edit'])->name('products.edit')
        ->can('update', 'App\\Models\\Product');
    Route::put('/products/{product:name}', [ProductController::class, 'update'])->name('products.update')
        ->can('update', 'App\\Models\\Product');
    Route::delete('/products/{product:name}', [ProductController::class, 'destroy'])->name('products.destroy')
        ->can('delete', 'App\\Models\\Product');
});

// Cart and Order
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::post('/order', [OrderController::class, 'order'])->name('order');
});

// Profile
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth
require __DIR__.'/auth.php';
