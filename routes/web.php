<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReastauransController;
use App\Http\Controllers\StadesController;
use App\Http\Controllers\MatchesController;
use App\Http\Controllers\EquipesController;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\RestaurantController;
use App\Models\Hotels;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});






Route::get('/stades', [StadesController::class, 'index'])->name('stades');
Route::get("/matches", [MatchesController::class, 'index'])->name('matches');
Route::get("/equipes", [EquipesController::class, 'index'])->name('equipes');
Route::get('/hotels', [HotelsController::class, 'index'])->name('hotels');




Route::get('/equipes/{id}', [EquipesController::class, 'show'])->name('equipes.show');
Route::get('/stades/{id}', [StadesController::class, 'show'])->name('stades.show');
Route::get('/hotels/{id}', [HotelsController::class, 'show'])->name('hotels.show');
Route::get('/matches/{id}', [MatchesController::class, 'show'])->name('matches.show');



require __DIR__.'/auth.php';
