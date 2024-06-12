<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\MovieDBController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\FavouriteController;

Route::middleware(['api', 'auth'])->group(function () {
    Route::apiResources(['favoritos' => FavouriteController::class], ['only' => ['index', 'store', 'show', 'destroy']])->names([
        'index' => 'api.favourite.index',
        'store' => 'api.favourite.store',
        'show' => 'api.favourite.show',
        'update' => 'api.favourite.update',
        'destroy' => 'api.favourite.destroy'
    ]);
    Route::get('/favoritos/buscar', [FavouriteController::class, 'find'])->name('api.favourite.find');
    Route::post('/favoritos/{movieId}/toggle', [FavouriteController::class, 'toggle']);
    Route::post('/favoritos/{movie_id}/remove', [FavouriteController::class, 'destroy']);

});



Route::get("/favorites/{user}", [FavoritesController::class, 'getFavourites'])->name('favourites.ingex');
Route::get("/addfavourites/{user}/{movie}", [FavoritesController::class, 'addFavourite'])->name('favourites.add');
Route::get("/removefavourites/{user}/{movie}", [FavoritesController::class, 'delFavourite'])->name('favourites.del');


require __DIR__ . '/auth.php';
