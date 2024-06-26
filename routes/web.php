<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

//Shop
require __DIR__.'/shop.php';

// Navigation
Route::view('/', 'home')->name('home');
Route::view('/about-us', 'about-us')->name('about-us');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::view('/contact', 'contact')->name('contact');

//Inventory
Route::get('/inventory', [InventoryController::class, 'index'])
    ->middleware(['admin']) 
    ->name('inventory');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth
require __DIR__.'/auth.php';