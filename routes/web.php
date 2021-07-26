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

Route::get('/helper', [\App\Http\Controllers\HelperView::class, 'index'])->name('helperview');

Route::get('/', [App\Http\Controllers\HomeClientController::class, 'index'])->name('/');
Route::get('search/{fiter}/{search}', [App\Http\Controllers\Client\SearchController::class, 'index'])->name('search');

Auth::routes();
Route::group(['middleware' => ['auth', 'roles']], function () {
    Route::group(['prefix' => 'client', 'roles' => 'klien'], function () {
        Route::get('home', [App\Http\Controllers\HomeClientController::class, 'index'])->name('homeclient');
        Route::get('wishlist', [App\Http\Controllers\Client\WishlistController::class, 'index'])->name('wishlist');
        Route::group(['prefix' => 'wishlist'], function () {
            Route::get('add/{id}', [App\Http\Controllers\Client\WishlistController::class, 'create'])->name('add.wishlist');
            Route::get('remove/{id}', [App\Http\Controllers\Client\WishlistController::class, 'destroy'])->name('remove.wishlist');
        });

    });
    Route::group(['roles' => ['admin','tukang']], function () {
        Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('produk', [App\Http\Controllers\Tukang\ProdukController::class, 'index'])->name('produk');
        Route::get('produk/add', [App\Http\Controllers\Tukang\ProdukController::class, 'create'])->name('add.produk');
        Route::post('produk/store', [App\Http\Controllers\Tukang\ProdukController::class, 'store'])->name('store.produk');
        Route::get('produk/show', [App\Http\Controllers\Tukang\ProdukController::class, 'show'])->name('show.produk');
        Route::post('produk/update/{id}', [App\Http\Controllers\Tukang\ProdukController::class, 'update'])->name('update.produk');
        Route::get('produk/delete/{id}', [App\Http\Controllers\Tukang\ProdukController::class, 'destroy'])->name('destroy.produk');
        Route::get('produk/json', [App\Http\Controllers\Tukang\ProdukController::class, 'json'])->name('data.produk.json');

        Route::group(['prefix' => 'pengajuan'], function () {
            Route::get('/', [App\Http\Controllers\Tukang\PengajuanController::class, 'index'])->name('pengajuan');
            Route::get('json', [App\Http\Controllers\Tukang\PengajuanController::class, 'json'])->name('data.pengajuan.json');
            Route::get('show/{id}', [App\Http\Controllers\Tukang\PengajuanController::class, 'show'])->name('show.pengajuan');
            Route::get('tolak/{id}', [App\Http\Controllers\Tukang\PengajuanController::class, 'tolak_pengajuan'])->name('tolak.pengajuan');
        });

        Route::group(['prefix' => 'penawaran'], function () {
            Route::get('/', [App\Http\Controllers\Tukang\PenawaranController::class, 'index'])->name('penawaran');
            Route::get('json', [App\Http\Controllers\Tukang\PenawaranController::class, 'json'])->name('data.penawaran.json');
            Route::get('show/{id}', [App\Http\Controllers\Tukang\PenawaranController::class, 'show'])->name('show.penawaran');
            Route::get('add/bypengajuan/{id}', [App\Http\Controllers\Tukang\PenawaranController::class, 'create'])->name('add.penawaran.bypengajuan');
            Route::post('store', [App\Http\Controllers\Tukang\PenawaranController::class, 'store'])->name('store.penawaran.json');
        });
    });
});

Route::group(['prefix' => 'payment-gateway-testing'], function () {
    Route::get('/getBalance',[App\Http\Controllers\PaymentGateway\PembayaranController::class, 'getBalance']);
    Route::get('/createInvoice',[App\Http\Controllers\PaymentGateway\PembayaranController::class, 'createInvoice']);
    Route::get('/getInvoice/{id}',[App\Http\Controllers\PaymentGateway\PembayaranController::class, 'getInvoice']);
    Route::get('/getAllInvoice',[App\Http\Controllers\PaymentGateway\PembayaranController::class, 'getAllInvoice']);
    Route::get('/createPayout',[App\Http\Controllers\PaymentGateway\PembayaranController::class, 'createPayout']);
    Route::get('/getPayout/{id}',[App\Http\Controllers\PaymentGateway\PembayaranController::class, 'getPayout']);
    Route::get('/voidPayout/{id}',[App\Http\Controllers\PaymentGateway\PembayaranController::class, 'voidPayout']);
});
