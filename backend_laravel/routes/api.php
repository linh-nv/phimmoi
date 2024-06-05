<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\GenreController;

use function App\Helpers\convert_to_slug;

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


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('refresh', [AuthController::class, 'refresh']);
Route::get('me', [AuthController::class, 'userProfile'])->middleware('jwt.verify');

Route::group(['middleware' => 'jwt.verify'], function () {
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('genre', GenreController::class);
    Route::apiResource('country', CountryController::class);

    Route::group(['prefix' => 'destroy'], function () {
        Route::delete('category', [CategoryController::class, 'destroyMultiple']);
        Route::delete('genre', [GenreController::class, 'destroyMultiple']);
        Route::delete('country', [CountryController::class, 'destroyMultiple']);
    });
});
