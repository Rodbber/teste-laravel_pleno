<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'users', 'as' => 'users.'], function(){
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::patch('/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('delete');
});

Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');

Route::group(['prefix' => 'products', 'as' => 'products.'], function(){
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/price-greater-than/{price}', [ProductController::class, 'getAllPriceGreaterThan'])->name('price-greater-than');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::patch('/{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('delete');
});


Route::get('/is-prime/{number}', [Controller::class, 'isPrime'])->name('is-prime');
