<?php

use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AnalysisController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\EpisodeController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EnumController;
use App\Http\Controllers\Client\CategoryController as ClientCategoryController;
use App\Http\Controllers\Client\CountryController as ClientCountryController;
use App\Http\Controllers\Client\GenreController as ClientGenreController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\MovieCommentController;
use App\Http\Controllers\Client\MovieController as ClientMovieController;
use App\Http\Controllers\Client\MovieUserController;
use App\Http\Controllers\Client\MovieViewController;

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
// Admin routes
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

Route::group(['middleware' => 'jwt.verify'], function () {
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('genre', GenreController::class);
    Route::apiResource('country', CountryController::class);
    Route::post('movie/{slug}', [MovieController::class, 'update']);
    Route::apiResource('movie', MovieController::class);
    Route::apiResource('episode', EpisodeController::class);
    Route::get('episode/movie/{slug}', [EpisodeController::class, 'getByMovie']);
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

    Route::get('/overview', [AnalysisController::class, 'overview']);

});

// Client routes
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login'])->name('login');
Route::post('refresh', [UserController::class, 'refresh']);

Route::group(['middleware' => 'jwt.verify'], function () {
    Route::get('redirect', [UserController::class, 'redirect']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::post('change-password', [UserController::class, 'changePassWord']);
    Route::get('me', [UserController::class, 'userProfile']);
});

Route::group(['prefix' => 'client', 'middleware' => 'cacheResponse'], function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/search', [ClientMovieController::class, 'search']);
    Route::get('/filter', [ClientMovieController::class, 'filter']);
    Route::get('/header', [HomeController::class, 'header']);
    Route::get('/slider', [HomeController::class, 'slider']);
    Route::get('/filter-option', [HomeController::class, 'filterOption']);
    Route::get('/category/{slug}', [ClientCategoryController::class, 'index']);
    Route::get('/genre/{slug}', [ClientGenreController::class, 'index']);
    Route::get('/country/{slug}', [ClientCountryController::class, 'index']);
    Route::get('/movie/{slug}', [ClientMovieController::class, 'index']);
    Route::get('/movie-top', [MovieViewController::class, 'getAll']);
    Route::get('/movie-top/day', [MovieViewController::class, 'moviesDay']);
    Route::get('/movie-top/week', [MovieViewController::class, 'moviesWeek']);
    Route::get('/movie-top/month', [MovieViewController::class, 'moviesMonth']);
    Route::get('/movie-top/year', [MovieViewController::class, 'moviesYear']);
    Route::get('/create-view/{id}', [MovieViewController::class, 'createView']);
    Route::get('/comment/{slug}', [MovieCommentController::class, 'getAll']);

    Route::group(['middleware' => 'jwt.verify'], function () {
        Route::get('/favorite/{id}', [MovieUserController::class, 'getAll']);
        Route::post('/favorite', [MovieUserController::class, 'insertOrRemove']);
        Route::get('/favorite/exist/{movieId}', [MovieUserController::class, 'exist']);
        Route::post('comment', [MovieCommentController::class, 'create']);
        Route::delete('comment/{id}', [MovieCommentController::class, 'delete']);
    });
});
