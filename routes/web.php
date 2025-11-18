<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistributorController;

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
Route::resource('/distributors', DistributorController::class);
Route::get('/test', [TestController::class, 'index']);
