<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

// Navigation
Route::view('/', 'home')->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::view('/about-us', 'about-us')->name('about-us');
Route::view('/contact', 'contact')->name('contact');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Inventory, Categories, and Products
Route::middleware(['admin'])->group(function () {    
    Route::get('/inventory', [InventoryController::class, 'index'])
        ->name('inventory.index');
    Route::get('/products/create', [ProductController::class, 'create'])
        ->name('products.create');
    Route::post('/products/create', [ProductController::class, 'store'])
        ->name('products.store');
    Route::get('/products/{product:name}/edit', [ProductController::class, 'edit'])
        ->name('products.edit');
    Route::put('/products/{product:name}', [ProductController::class, 'update'])
        ->name('products.update');
    Route::delete('/products/{product:name}', [ProductController::class, 'destroy'])
        ->name('products.destroy');
});
Route::get('/products/{product:name}', [ProductController::class, 'show'])->name('products.show'); // even guest can see this route

// Category
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create'); 
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store'); 

// Cart
Route::middleware('auth')->group(function() {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
});

// Order
Route::post('/order', [OrderController::class, 'store'])
    ->middleware('auth')
    ->name('order');
Route::middleware('admin')->group(function(){

});

// Auth
require __DIR__.'/auth.php';