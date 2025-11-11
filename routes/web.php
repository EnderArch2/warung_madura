<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/test', function () {
//     return view('test');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// });

Route::resource('/dashboard', App\Http\Controllers\DashboardController::class);
Route::resource('/test', App\Http\Controllers\TestController::class);
