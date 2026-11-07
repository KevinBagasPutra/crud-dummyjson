<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::get('products/search', [ProductController::class, 'index'])->name('products.search');
    Route::get('products/categories', [ProductController::class, 'categories'])->name('products.categories');
    Route::get('products/category/{slug}', [ProductController::class, 'index'])->name('products.category');
    Route::apiResource('products', ProductController::class);
});