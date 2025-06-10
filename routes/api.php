<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\StadesController;
use App\Http\Controllers\MatchesController;
use App\Http\Controllers\EquipesController;
use App\Http\Controllers\ActivityController;

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


Route::get("/equipes", [EquipesController::class, 'index'])->name('equipes');
Route::get('/equipes/{id}', [EquipesController::class, 'show'])->name('equipes.show');
Route::post('/equipes', [EquipesController::class, 'store'])->name('equipes.store');
Route::put('/equipes/{id}', [EquipesController::class, 'update'])->name('equipes.update');
Route::delete('/equipes/{id}', [EquipesController::class, 'destroy'])->name('equipes.destroy');


Route::get("/matches", [MatchesController::class, 'index'])->name('matches');
Route::get('/matches/{id}', [MatchesController::class, 'show'])->name('matches.show');
Route::post('/matches', [MatchesController::class, 'store'])->name('matches.store');
Route::put('/matches/{id}', [MatchesController::class, 'update'])->name('matches.update');
Route::delete('/matches/{id}', [MatchesController::class, 'destroy'])->name('matches.destroy');



Route::get('/stades', [StadesController::class, 'index'])->name('stades.index');
Route::get('/stades/{id}', [StadesController::class, 'show'])->name('stades.show');
Route::post('/stades', [StadesController::class, 'store'])->name('stades.store');
Route::put('/stades/{id}', [StadesController::class, 'update'])->name('stades.update');
Route::delete('/stades/{id}', [StadesController::class, 'destroy'])->name('stades.destroy');


Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
Route::get('/activities/{id}', [ActivityController::class, 'show'])->name('activities.show');
Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
Route::put('/activities/{id}', [ActivityController::class, 'update'])->name('activities.update');
Route::delete('/activities/{id}', [ActivityController::class, 'destroy'])->name('activities.destroy');




