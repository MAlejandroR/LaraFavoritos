<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\MovieDBController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\FavouriteController;

// Route::get('/peliculas-series', function () {
//     return Inertia::render('Movies/Index');
// })->middleware('auth')->name('movies.index');

Route::resource('movies', MovieController::class)->only('index', 'store', 'update', 'destroy')->middleware('auth');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/inicio', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/miperfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/miperfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/miperfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/peliculas', [MovieDBController::class, 'index'])->name('popularmovies/index')->middleware('auth');

Route::get('/favoritos', function () {
    return Inertia::render('Favourites/Index');
})->name('favourites.index');

Route::get('/test', [MovieDBController::class, 'getMovie']);
require __DIR__ . '/auth.php';

Route::get("/favorites/{user}", [FavouriteController::class, 'getFavorites'])->name('favorites.ingex');
Route::get("/addFavorite/{user}/{movie}", [FavouriteController::class, 'addFavorite'])->name('favorites.add');
Route::get("/delFavorite/{user}/{movie}", [FavouriteController::class, 'delFavorite'])->name('favorites.del');
