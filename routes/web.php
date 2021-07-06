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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('produk',[App\Http\Controllers\Tukang\ProdukController::class, 'index'])->name('produk');
Route::get('produk/show',[App\Http\Controllers\Tukang\ProdukController::class, 'show'])->name('show.produk');
Route::post('produk/update/{id}',[App\Http\Controllers\Tukang\ProdukController::class, 'update'])->name('update.produk');
Route::get('produk/json',[App\Http\Controllers\Tukang\ProdukController::class, 'json'])->name('data.produk.json');
