<?php

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


Route::get('/', [App\Http\Controllers\HomeClientController::class, 'index'])->name('/');
Route::get('/client/home', [App\Http\Controllers\HomeClientController::class, 'index'])->name('homeclient');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('produk',[App\Http\Controllers\Tukang\ProdukController::class, 'index'])->name('produk');
Route::get('produk/add',[App\Http\Controllers\Tukang\ProdukController::class, 'create'])->name('add.produk');
Route::post('produk/store',[App\Http\Controllers\Tukang\ProdukController::class, 'store'])->name('store.produk');
Route::get('produk/show',[App\Http\Controllers\Tukang\ProdukController::class, 'show'])->name('show.produk');
Route::post('produk/update/{id}',[App\Http\Controllers\Tukang\ProdukController::class, 'update'])->name('update.produk');
Route::get('produk/delete/{id}',[App\Http\Controllers\Tukang\ProdukController::class, 'destroy'])->name('destroy.produk');
Route::get('produk/json',[App\Http\Controllers\Tukang\ProdukController::class, 'json'])->name('data.produk.json');
