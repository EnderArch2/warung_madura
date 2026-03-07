<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Route::resource() registers 7 RESTful routes at once:
|   GET    /products           → index()    (list all)
|   GET    /products/create    → create()   (show create form)
|   POST   /products           → store()    (save new record)
|   GET    /products/{id}      → show()     (view one record)
|   GET    /products/{id}/edit → edit()     (show edit form)
|   PUT    /products/{id}      → update()   (save changes)
|   DELETE /products/{id}      → destroy()  (delete record)
|
| All routes are automatically NAMED: products.index, products.create, etc.
| Use route('products.index') in Blade or controllers to generate URLs.
| This way, if you change /products to /barang, all links update automatically.
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/dashboard', DashboardController::class);
Route::resource('/distributors', DistributorController::class);

// Sale CRUD (for cashier / transaction entry)
Route::resource('sales', \App\Http\Controllers\SaleController::class);

// Sale Reports (for manager / analytical view)
Route::get('sale-reports', [\App\Http\Controllers\SaleReportController::class, 'index'])->name('sale-reports.index');

Route::resource('products', \App\Http\Controllers\ProductController::class);
Route::get('/test', [TestController::class, 'index']);
