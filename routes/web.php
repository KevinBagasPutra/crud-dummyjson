<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('products.index'));
Route::get('products/search', [ProductController::class, 'index'])->name('products.search');
Route::get('products/category/{slug}', [ProductController::class, 'index'])->name('products.category');
Route::resource('products', ProductController::class);