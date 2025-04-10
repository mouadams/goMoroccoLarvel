<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\HotelsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
Route::get('/restaurants/{id}', [RestaurantController::class, 'show'])->name('restaurants.show');
Route::post('/restaurants', [RestaurantController::class, 'store'])->name('restaurants.store');
Route::put('/restaurants/{id}', [RestaurantController::class, 'update'])->name('restaurants.update');
Route::delete('restaurants/{id}', [RestaurantController::class, 'destroy']);


Route::get('/hotels', [HotelsController::class, 'index'])->name('hotels');
Route::get('/hotels/{id}', [HotelsController::class, 'show'])->name('hotels.show');
Route::post('/hotels', [HotelsController::class, 'store'])->name('hotels.store');
Route::put('/hotels/{id}', [HotelsController::class, 'update'])->name('hotels.update');
Route::delete('/hotels/{id}', [HotelsController::class, 'destroy'])->name('hotels.delet');

