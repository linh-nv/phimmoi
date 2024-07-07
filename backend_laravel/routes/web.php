<?php

use App\Enums\Status;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', function () {
    $statusValue = 1;
    $label = Status::labelFromValue($statusValue);
    echo $label;
});
