<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EnumController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'admin'], function () {
    Route::post('register', [AdminController::class, 'register']);
    Route::post('login', [AdminController::class, 'login']);
    Route::post('refresh', [AdminController::class, 'refresh']);
    Route::group(['middleware' => 'jwt.verify'], function () {
        Route::post('logout', [AdminController::class, 'logout']);
        Route::post('change-password', [AdminController::class, 'changePassword']);
        Route::get('me', [AdminController::class, 'adminProfile']);
    });
});

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login'])->name('login');
Route::post('refresh', [UserController::class, 'refresh']);

Route::group(['middleware' => 'jwt.verify'], function () {
    Route::post('logout', [UserController::class, 'logout']);
    Route::post('change-password', [UserController::class, 'changePassWord']);
    Route::get('me', [UserController::class, 'userProfile']);

    Route::apiResource('category', CategoryController::class);
    Route::apiResource('genre', GenreController::class);
    Route::apiResource('country', CountryController::class);
    Route::apiResource('movie', MovieController::class);
    Route::apiResource('episode', EpisodeController::class);
    Route::apiResource('address', AddressController::class);

    Route::group(['prefix' => 'destroy'], function () {
        Route::delete('category', [CategoryController::class, 'destroyMultiple']);
        Route::delete('genre', [GenreController::class, 'destroyMultiple']);
        Route::delete('country', [CountryController::class, 'destroyMultiple']);
        Route::delete('movie', [MovieController::class, 'destroyMultiple']);
        Route::delete('episode', [EpisodeController::class, 'destroyMultiple']);
        Route::delete('address', [AddressController::class, 'destroyMultiple']);
    });

    Route::group(['prefix' => 'pluck'], function () {
        Route::get('category', [CategoryController::class, 'pluckTitle']);
        Route::get('genre', [GenreController::class, 'pluckTitle']);
        Route::get('country', [CountryController::class, 'pluckTitle']);
    });

    Route::get('/enums', [EnumController::class, 'getAllEnums']);
    Route::get('/enums/status', [EnumController::class, 'getStatus']);
    Route::get('/enums/movie-quality', [EnumController::class, 'getMovieQuality']);
    Route::get('/enums/movie-status', [EnumController::class, 'getMovieStatus']);
    Route::get('/enums/movie-type', [EnumController::class, 'getMovieType']);
});
