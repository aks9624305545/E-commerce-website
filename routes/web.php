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
    
    Route::get('/categories', [CategoriesController::class, 'showCategories'])->name('categories');
    Route::get('/addUpdateCategories/{id?}', [CategoriesController::class, 'addUpdateCategories'])->name('addUpdateCategories');
    Route::post('/addCategories', [CategoriesController::class, 'addCategories'])->name('addCategories');
    Route::get('/getCategories', [CategoriesController::class, 'getCategories'])->name('getCategories');
    Route::get('/deleteCategories/{id?}', [CategoriesController::class, 'deleteCategories'])->name('deleteCategories');
    
    Route::get('/sub-categories', [SubCategoriesController::class, 'showSubCategories'])->name('subCategories');
    
    Route::get('/products', [ProductsController::class, 'showProducts'])->name('products');
});

require __DIR__.'/auth.php';
