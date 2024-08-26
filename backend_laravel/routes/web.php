<?php

use App\Enums\MovieQuality;
use App\Enums\MovieType;
use App\Util\Constains;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', function () {
    $apiUrl = Constains::API_CRAWL_DETAILS_MOVIE . 'bay-nuot-mang';
    $response = Http::get($apiUrl);
    return $response['movie']['created']['time'];
});
