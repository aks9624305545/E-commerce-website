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
    Route::get('/getUsers', [ProfileController::class, 'getUsers'])->name('getUsers');
    Route::get('/deleteUsers', [ProfileController::class, 'deleteUsers'])->name('deleteUsers');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile_image', [ProfileController::class, 'profileImage'])->name('profileImage');
    
    Route::get('/categories', [CategoriesController::class, 'showCategories'])->name('categories');
    Route::get('/addUpdateCategories/{id?}', [CategoriesController::class, 'addUpdateCategories'])->name('addUpdateCategories');
    Route::post('/addCategories', [CategoriesController::class, 'addCategories'])->name('addCategories');
    Route::get('/getCategories', [CategoriesController::class, 'getCategories'])->name('getCategories');
    Route::get('/deleteCategories/{id?}', [CategoriesController::class, 'deleteCategories'])->name('deleteCategories');
    Route::post('/updateCategories/{id?}', [CategoriesController::class, 'updateCategories'])->name('updateCategories');
    
    Route::get('/sub-categories', [SubCategoriesController::class, 'showSubCategories'])->name('subCategories');
    Route::get('/addUpdateSubCategories/{id?}', [SubCategoriesController::class, 'addUpdateSubCategories'])->name('addUpdateSubCategories');
    Route::post('/addSubCategories', [SubCategoriesController::class, 'addSubCategories'])->name('addSubCategories');
    Route::get('/getSubCategories', [SubCategoriesController::class, 'getSubCategories'])->name('getSubCategories');
    Route::get('/deleteSubCategories/{id?}', [SubCategoriesController::class, 'deleteSubCategories'])->name('deleteSubCategories');
    Route::post('/updateSubCategories/{id?}', [SubCategoriesController::class, 'updateSubCategories'])->name('updateSubCategories');
    
    Route::get('/products', [ProductsController::class, 'showProducts'])->name('products');
    Route::get('/addUpdateProducts/{id?}', [ProductsController::class, 'addUpdateProducts'])->name('addUpdateProducts');
    Route::post('/addProducts', [ProductsController::class, 'addProducts'])->name('addProducts');
    Route::get('/getProducts', [ProductsController::class, 'getProducts'])->name('getProducts');
    Route::get('/deleteProducts/{id?}', [ProductsController::class, 'deleteProducts'])->name('deleteProducts');
    Route::post('/updateProducts/{id?}', [ProductsController::class, 'updateProducts'])->name('updateProducts');
});

require __DIR__.'/auth.php';
