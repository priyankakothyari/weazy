<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\FrontController;

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

//--------------front -------

Route::match(['get','post'],'login',[FrontController::class,'login'])->name('login');
Route::get('/',[FrontController::class,'index'])->name('index');

Route::prefix('user')->name('user.')->group(function () {
    Route::get('logout',[FrontController::class,'login'])->name('logout');
    Route::post('/cart',[FrontController::class,'addToCart'])->name('add_to_cart');   
    Route::post('/wishlist',[FrontController::class,'addToWishlist'])->name('add_to_wishlist');   
});