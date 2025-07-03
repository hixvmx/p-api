<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// undefined routes
Route::fallback(function () {
    return view('welcome');
});