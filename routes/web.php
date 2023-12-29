<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SearchSummonerController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\RotationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [RotationController::class, 'showRotation'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/summoner/search', [SearchSummonerController::class, 'searchSummoner'])->name('summoner.searchSummoner');
    Route::get('/search', [SearchSummonerController::class, 'index'])->name('searchSummoner');
    Route::match(['get', 'post'], '/favorites', [FavoritesController::class, 'manage'])->name('favorites');
    Route::delete('/favorites/{id}', [FavoritesController::class, 'destroy'])->name('favorites.destroy');
});

Route::middleware(['auth'])->group(function () {
});

require __DIR__ . '/auth.php';
