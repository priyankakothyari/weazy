<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProv
ider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('test', function () {
    return "hi";
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::match(['get', 'post'], 'login', [
        AuthController::class,
        'login',
    ])->name('login');
    Route::get('signout', [AuthController::class, 'signOut'])->name('signout');

    Route::middleware('auth:admin')->group(function () {
        Route::resource('category', CategoryController::class);
        Route::resource('product', ProductController::class);
        Route::get('dashboard', function () {
            return view('admin/dashboard');
        })->name('dashboard');
    });
});
