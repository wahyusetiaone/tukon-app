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

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('details', 'App\Http\Controllers\API\UserController@details');
    Route::group(['prefix'=>'tukang','as'=>'tukang.'], function() {
        Route::group(['prefix'=>'barang','as'=>'barang.'], function() {
            Route::get('get', 'App\Http\Controllers\API\ProdukController@index')->name('get');
            Route::get('show/{id}', 'App\Http\Controllers\API\ProdukController@show')->name('show');
            Route::post('tambah', 'App\Http\Controllers\API\ProdukController@store')->name('tambah');
            Route::post('update', 'App\Http\Controllers\API\ProdukController@update')->name('update');
            Route::delete('hapus/{id}', 'App\Http\Controllers\API\ProdukController@destroy')->name('hapus');
        });
    });
});
