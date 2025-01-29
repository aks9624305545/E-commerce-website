<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SubCategoriesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile_image', [ProfileController::class, 'profileImage'])->name('profileImage');
    
    Route::get('/products', [ProductsController::class, 'showProducts'])->name('products');
    Route::get('/categories', [CategoriesController::class, 'showCategories'])->name('categories');
    Route::get('/sub-categories', [SubCategoriesController::class, 'showSubCategories'])->name('subCategories');
});

require __DIR__.'/auth.php';
