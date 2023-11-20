<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\RiotController;

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
    Route::get('/dashboard', [RiotController::class, 'rotation'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/summoner/search', [RiotController::class, 'searchSummoner'])->name('summoner.search');
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::match(['get', 'post'], '/favorites', [RiotController::class, 'manageFavorites'])->name('favorites');

});

Route::middleware(['auth'])->group(function () {
});

require __DIR__ . '/auth.php';
