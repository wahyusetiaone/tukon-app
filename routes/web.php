<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('home_client');
//});
//
//Route::get('/client/home', function () {
//    return view('home_client');
//})->name('client.home');
//

//Route::group(['roles'=>'Admin'],function(){
//    Route::resource('user', 'UserController');
//});

Route::get('/', [App\Http\Controllers\HomeClientController::class, 'index'])->name('/');

Auth::routes();
Route::group(['middleware' => ['auth','roles']], function () {
    Route::group(['prefix' => 'client', 'roles' => 'klien'], function () {
        Route::get('home', [App\Http\Controllers\HomeClientController::class, 'index'])->name('homeclient');
        Route::get('wishlist', [App\Http\Controllers\Client\WishlistController::class, 'index'])->name('wishlist');
        Route::get('wishlist/add/{id}', [App\Http\Controllers\Client\WishlistController::class, 'create'])->name('add.wishlist');
    });
    Route::group(['roles' => 'admin'], function () {
        Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('produk', [App\Http\Controllers\Tukang\ProdukController::class, 'index'])->name('produk');
        Route::get('produk/add', [App\Http\Controllers\Tukang\ProdukController::class, 'create'])->name('add.produk');
        Route::post('produk/store', [App\Http\Controllers\Tukang\ProdukController::class, 'store'])->name('store.produk');
        Route::get('produk/show', [App\Http\Controllers\Tukang\ProdukController::class, 'show'])->name('show.produk');
        Route::post('produk/update/{id}', [App\Http\Controllers\Tukang\ProdukController::class, 'update'])->name('update.produk');
        Route::get('produk/delete/{id}', [App\Http\Controllers\Tukang\ProdukController::class, 'destroy'])->name('destroy.produk');
        Route::get('produk/json', [App\Http\Controllers\Tukang\ProdukController::class, 'json'])->name('data.produk.json');
    });
});
