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
Route::view('/about-us', 'about-us')->name('about-us');
Route::view('/contact', 'contact')->name('contact');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Menu
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{product:name}', [MenuController::class, 'showProduct'])->name('menu.showProduct'); 


// Inventory, Categories, and Products (admin)
Route::middleware(['admin'])->group(function () {
    // Category
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create'); 
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    // Inventory 
    Route::get('/inventory', [InventoryController::class, 'index'])
        ->name('inventory.index');
    // Products
    Route::get('/products/create', [ProductController::class, 'create'])
        ->name('products.create');
    Route::post('/products/create', [ProductController::class, 'store'])
        ->name('products.store');
    Route::get('/products/{product:name}', [ProductController::class, 'show'])
    ->name('products.show'); 
    Route::get('/products/{product:name}/edit', [ProductController::class, 'edit'])
        ->name('products.edit');
    Route::put('/products/{product:name}', [ProductController::class, 'update'])
        ->name('products.update');
    Route::delete('/products/{product:name}', [ProductController::class, 'destroy'])
        ->name('products.destroy');
});

// Cart (buyer)
Route::middleware('auth')->group(function() {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart/edit/{cartItem}', [CartController::class, 'edit'])->name('cart.edit');
    Route::put('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::put('/cart/addQuantity/{cartItem}', [CartController::class, 'addQuantity'])->name('cart.addQuantity');
    Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
});

// Orders (buyer)
Route::middleware('auth')->group(function(){
    Route::post('/orders', [OrderController::class, 'store'])
        ->name('orders.store');
    Route::get('/orders/{order}/success', [OrderController::class, 'showOrderSuccess'])
        ->can('view', 'order')
        ->name('orders.success');
});

// Orders (admin or barista)
Route::middleware('can:baristaOrAdmin')->group(function(){
    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])
        ->name('orders.show');
    Route::put('/orders/{order}', [OrderController::class,'update'])
        ->name('orders.update');
});

// Auth
require __DIR__.'/auth.php';