<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/test', function () {
//     return view('test');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// });

Route::resource('/dashboard', DashboardController::class);
Route::resource('/test', TestController::class);
// Route::get('/test', [TestController::class, 'index']);
