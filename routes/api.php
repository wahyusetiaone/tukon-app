<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'App\Http\Controllers\API\UserController@login');
Route::post('register', 'App\Http\Controllers\API\UserController@register');
Route::group(['prefix' => 'guest', 'as' => 'guest'], function () {
    Route::get('beranda', 'App\Http\Controllers\API\BerandaController@index')->name('beranda');
    Route::get('new_product', 'App\Http\Controllers\API\BerandaController@new_product')->name('produk.terbaru');
    Route::get('top_tukang', 'App\Http\Controllers\API\BerandaController@top_tukang')->name('top.tukang');
    Route::group(['prefix' => 'search', 'as' => 'search'], function () {
        Route::post('produk', 'App\Http\Controllers\API\ProdukController@search')->name('produk');
        Route::post('new_product', 'App\Http\Controllers\API\BerandaController@search_new_product')->name('produk_terbaru');
        Route::post('top_tukang', 'App\Http\Controllers\API\BerandaController@search_top_tukang')->name('top.tukang');
    });
});

Route::group(['middleware' => ['auth:api', 'roles']], function () {
    Route::get('details', 'App\Http\Controllers\API\UserController@details');
    Route::group(['prefix' => 'tukang', 'as' => 'tukang', 'roles' => 'tukang'], function () {
        Route::group(['prefix' => 'produk', 'as' => 'produk'], function () {
            Route::get('get', 'App\Http\Controllers\API\ProdukController@index')->name('get');
            Route::get('show/{id}', 'App\Http\Controllers\API\ProdukController@show')->name('show');
            Route::post('tambah', 'App\Http\Controllers\API\ProdukController@store')->name('tambah');
            Route::post('update', 'App\Http\Controllers\API\ProdukController@update')->name('update');
            Route::delete('hapus/{id}', 'App\Http\Controllers\API\ProdukController@destroy')->name('hapus');
        });
        Route::group(['prefix' => 'penawaran', 'as' => 'penawaran'], function () {
            Route::post('add', 'App\Http\Controllers\API\PenawaranController@create')->name('add');
            Route::post('update/{id}', 'App\Http\Controllers\API\PenawaranController@update')->name('update');
            Route::delete('remove/{id}', 'App\Http\Controllers\API\PenawaranController@destroy')->name('remove');
            Route::delete('komponen/remove/{id}', 'App\Http\Controllers\API\PenawaranController@destroy_komponen')->name('komponen.remove');
            Route::post('komponen/update/{id}', 'App\Http\Controllers\API\PenawaranController@update_komponen')->name('komponen.update');
        });

    });
    Route::group(['prefix' => 'client', 'as' => 'client', 'roles' => 'klien'], function () {
        Route::post('rate-it', 'App\Http\Controllers\API\RatingController@send')->name('send_it');
        Route::post('change-rate/{id}', 'App\Http\Controllers\API\RatingController@change')->name('change-it');
        Route::group(['prefix' => 'wishlist', 'as' => 'wishlist'], function () {
            Route::get('get', 'App\Http\Controllers\API\WishlistController@index')->name('get');
            Route::post('remove', 'App\Http\Controllers\API\WishlistController@remove')->name('remove');
            Route::post('add', 'App\Http\Controllers\API\WishlistController@add')->name('add');
        });
        Route::group(['prefix' => 'pengajuan', 'as' => 'pengajuan'], function () {
            Route::get('get', 'App\Http\Controllers\API\PengajuanController@index')->name('get');
            Route::post('add', 'App\Http\Controllers\API\PengajuanController@create')->name('add');
            Route::delete('remove/{id}', 'App\Http\Controllers\API\PengajuanController@destroy')->name('remove');
            Route::post('update/{id}', 'App\Http\Controllers\API\PengajuanController@update')->name('update');
            Route::post('remove/photo/{id}', 'App\Http\Controllers\API\PengajuanController@destroy_photo')->name('remove.photo');
            Route::post('remove/tukang/{id}', 'App\Http\Controllers\API\PengajuanController@destroy_tukang')->name('remove.tukang');
        });
    });
});
