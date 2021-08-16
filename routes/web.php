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

Route::group(['prefix' => 'guest'], function () {
    Route::group(['prefix' => 'product'], function () {
        Route::get('show/{id}', [App\Http\Controllers\Guest\ProductController::class, 'show'])->name('show.produk.guest');
        Route::get('all', [App\Http\Controllers\Guest\ProductController::class, 'index'])->name('all.produk.guest');
        Route::get('new/all', [App\Http\Controllers\Guest\ProductController::class, 'index'])->name('all.new.produk.guest');
    });
    Route::group(['prefix' => 'tukang'], function () {
        Route::get('show/{id}', [App\Http\Controllers\Guest\TukangController::class, 'show'])->name('show.tukang.guest');
        Route::get('all', [App\Http\Controllers\Guest\TukangController::class, 'index'])->name('all.tukang.guest');
        Route::get('top/all', [App\Http\Controllers\Guest\TukangController::class, 'index_top'])->name('all.top.tukang.guest');
    });
});


Auth::routes();
Route::group(['middleware' => ['auth', 'roles']], function () {
    Route::group(['prefix' => 'client', 'roles' => 'klien'], function () {
        Route::get('home', [App\Http\Controllers\HomeClientController::class, 'index'])->name('homeclient');
        Route::get('wishlist', [App\Http\Controllers\Client\WishlistController::class, 'index'])->name('wishlist');
        Route::get('pengajuan', [App\Http\Controllers\Client\PengajuanController::class, 'index'])->name('pengajuan.client');
        Route::get('penawaran', [App\Http\Controllers\Client\PenawaranController::class, 'index'])->name('penawaran.client');
        Route::get('project', [App\Http\Controllers\Client\ProjectController::class, 'index'])->name('project.client');
        Route::get('pembayaran', [App\Http\Controllers\Client\PembayaranController::class, 'index'])->name('pembayaran.client');
//        Route::get('search/{filter}/{search}', [App\Http\Controllers\Client\SearchController::class, 'index'])->name('search');
        Route::group(['prefix' => 'wishlist'], function () {
            Route::get('add/{id}', [App\Http\Controllers\Client\WishlistController::class, 'create'])->name('add.wishlist');
            Route::get('remove/{id}', [App\Http\Controllers\Client\WishlistController::class, 'destroy'])->name('remove.wishlist');
        });
        Route::group(['prefix' => 'pengajuan'], function () {
            Route::get('form/{tukang}', [App\Http\Controllers\Client\PengajuanController::class, 'create'])->name('add.pengajuan.client');
            Route::post('store/{id}/{multi}/{kode_tukang}', [App\Http\Controllers\Client\PengajuanController::class, 'store'])->name('store.pengajuan.client');
            Route::get('show/{id}', [App\Http\Controllers\Client\PengajuanController::class, 'show'])->name('show.pengajuan.client');

        });
        Route::group(['prefix' => 'penawaran'], function () {
            Route::get('show/{id}', [App\Http\Controllers\Client\PenawaranController::class, 'show'])->name('show.penawaran.client');
        });
        Route::group(['prefix' => 'persetujuan', 'as' => 'persetujuan'], function () {
            Route::get('accept/{kode}/{id}', [App\Http\Controllers\Client\PersetujuanController::class, 'accept_client'])->name('web.accpet_client');
            Route::get('revisi/{kode}/{id}/{note}', [App\Http\Controllers\Client\PersetujuanController::class, 'revisi_client'])->name('web.revisi_client');
        });
        Route::group(['prefix' => 'pembayaran'], function () {
            Route::get('show/{id}', [App\Http\Controllers\Client\PembayaranController::class, 'show'])->name('show.pembayaran.client');
            Route::get('pay/offline/{id}', [App\Http\Controllers\Client\PembayaranController::class, 'createOffline'])->name('payoffline.pembayaran.client');
            Route::post('pay/offline/store/{id}', [App\Http\Controllers\Client\PembayaranController::class, 'storeOffline'])->name('store.payoffline.pembayaran.client');
//            Route::post('pay/{id}', [App\Http\Controllers\Client\PembayaranController::class, 'create'])->name('pay.pembayaran.client');
        });
        Route::group(['prefix' => 'project'], function () {
            Route::get('show/{id}', [App\Http\Controllers\Client\ProjectController::class, 'show'])->name('show.project.client');
            Route::get('approve/{id}', [App\Http\Controllers\Client\ProjectController::class, 'client_approve'])->name('client_approve.projek');
        });
        Route::group(['prefix' => 'penarikan-dana'], function () {
            Route::get('terima/{id}/{transaksi}', [App\Http\Controllers\Client\PenarikanDanaController::class, 'terima'])->name('terima.penarikan.dana');
            Route::get('tolak/{id}/{transaksi}', [App\Http\Controllers\Client\PenarikanDanaController::class, 'tolak'])->name('tolak.penarikan.dana');
        });
        Route::group(['prefix' => 'user'], function () {
            Route::get('profile', [App\Http\Controllers\Client\UserController::class, 'show'])->name('show.user.ptofile.client');
            Route::post('update/{id}', [App\Http\Controllers\Client\UserController::class, 'update'])->name('update.user.profile.client');
            Route::get('profile/new-password', [App\Http\Controllers\Client\UserController::class, 'showNewPassword'])->name('show.user.newpassword.client');
            Route::post('update/new-password/{id}', [App\Http\Controllers\Client\UserController::class, 'updateNewPassword'])->name('update.user.newpassword.client');
            Route::get('profile/change-photo', [App\Http\Controllers\Client\UserController::class, 'showChangePhoto'])->name('show.user.change.photo.client');
            Route::post('profile/upload/new-photo/{id}', [App\Http\Controllers\Client\UserController::class, 'updatePhotoUser'])->name('upload.user.photo.client');
        });
    });

    Route::group(['roles' => ['admin', 'tukang']], function () {
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
            Route::get('edit/{id}', [App\Http\Controllers\Tukang\PenawaranController::class, 'edit'])->name('edit.penawaran');
            Route::get('add/bypengajuan/{id}', [App\Http\Controllers\Tukang\PenawaranController::class, 'create'])->name('add.penawaran.bypengajuan');
            Route::post('store', [App\Http\Controllers\Tukang\PenawaranController::class, 'store'])->name('store.penawaran.json');
            Route::post('update/{id}', [App\Http\Controllers\Tukang\PenawaranController::class, 'update'])->name('update.penawaran.json');
        });
        Route::group(['prefix' => 'penawaran-offline'], function () {
            Route::get('/', [App\Http\Controllers\Tukang\PenawaranOfflineController::class, 'index'])->name('penawaran.offline');
            Route::get('json', [App\Http\Controllers\Tukang\PenawaranOfflineController::class, 'json'])->name('data.penawaran.offline.json');
            Route::get('add', [App\Http\Controllers\Tukang\PenawaranOfflineController::class, 'create'])->name('data.penawaran.offline.create');
            Route::post('store', [App\Http\Controllers\Tukang\PenawaranOfflineController::class, 'store'])->name('data.penawaran.offline.store');
            Route::get('show/{id}', [App\Http\Controllers\Tukang\PenawaranOfflineController::class, 'show'])->name('data.penawaran.offline.show');
            Route::get('edit/{id}', [App\Http\Controllers\Tukang\PenawaranOfflineController::class, 'edit'])->name('data.penawaran.offline.edit');
            Route::post('update/client/{id}', [App\Http\Controllers\Tukang\PenawaranOfflineController::class, 'update_client'])->name('data.penawaran.offline.update_client');
            Route::post('update/proyek/{id}', [App\Http\Controllers\Tukang\PenawaranOfflineController::class, 'update_proyek'])->name('data.penawaran.offline.update_proyek');
            Route::post('update/{id}', [App\Http\Controllers\Tukang\PenawaranOfflineController::class, 'update'])->name('data.penawaran.offline.update');
        });

        Route::group(['prefix' => 'persetujuan'], function () {
            Route::get('/t/{id}', [App\Http\Controllers\Tukang\PersetujuanController::class, 'index'])->name('persetujuan');
        });
        Route::group(['prefix' => 'projek'], function () {
            Route::get('/', [App\Http\Controllers\Tukang\ProjekController::class, 'index'])->name('projek');
            Route::get('json', [App\Http\Controllers\Tukang\ProjekController::class, 'json'])->name('data.projek.json');
            Route::get('show/{id}', [App\Http\Controllers\Tukang\ProjekController::class, 'show'])->name('show.projek');
            Route::get('approve/{id}', [App\Http\Controllers\Tukang\ProjekController::class, 'tukang_approve'])->name('tukang_approve.projek');

//            Route::get('edit/{id}', [App\Http\Controllers\Tukang\PenawaranController::class, 'edit'])->name('edit.projek');
//            Route::get('add/bypengajuan/{id}', [App\Http\Controllers\Tukang\PenawaranController::class, 'create'])->name('add.projek.bypengajuan');
//            Route::post('store', [App\Http\Controllers\Tukang\PenawaranController::class, 'store'])->name('store.projek.json');
        });
        Route::group(['prefix' => 'progress'], function () {
            Route::get('form/{id}', [App\Http\Controllers\Tukang\ProgressController::class, 'create'])->name('form.upload.progress');
            Route::post('upload/{id}', [App\Http\Controllers\Tukang\ProgressController::class, 'store'])->name('upload.progress');
        });
        Route::group(['prefix' => 'penarikan-dana'], function () {
            Route::get('/', [App\Http\Controllers\Tukang\PenarikanDanaController::class, 'index'])->name('penarikan.dana');
            Route::get('json', [App\Http\Controllers\Tukang\PenarikanDanaController::class, 'json'])->name('data.penarikan.dana.json');
            Route::get('show/{id}', [App\Http\Controllers\Tukang\PenarikanDanaController::class, 'show'])->name('show.penarikan.dana');
            Route::get('konfirmasi/{id}/{persen}', [App\Http\Controllers\Tukang\PenarikanDanaController::class, 'konfirmasi'])->name('konfirmasi.penarikan.dana');
            Route::post('store/{id}/{persen}', [App\Http\Controllers\Tukang\PenarikanDanaController::class, 'store'])->name('store.penarikan.dana');
        });
        //TODO::masih sama sama penawaran
        Route::group(['prefix' => 'history'], function () {
            Route::get('/', [App\Http\Controllers\Tukang\PenawaranController::class, 'index'])->name('history');
            Route::get('json', [App\Http\Controllers\Tukang\PenawaranController::class, 'json'])->name('data.history.json');
            Route::get('show/{id}', [App\Http\Controllers\Tukang\PenawaranController::class, 'show'])->name('show.history');
            Route::get('edit/{id}', [App\Http\Controllers\Tukang\PenawaranController::class, 'edit'])->name('edit.history');
            Route::get('add/bypengajuan/{id}', [App\Http\Controllers\Tukang\PenawaranController::class, 'create'])->name('add.history.bypengajuan');
            Route::post('store', [App\Http\Controllers\Tukang\PenawaranController::class, 'store'])->name('store.history.json');
        });
        Route::group(['prefix' => 'user'], function () {
            Route::get('profile', [App\Http\Controllers\Tukang\UserController::class, 'show'])->name('show.user.ptofile');
            Route::post('update/{id}', [App\Http\Controllers\Tukang\UserController::class, 'update'])->name('update.user.profile');
            Route::get('profile/new-password', [App\Http\Controllers\Tukang\UserController::class, 'showNewPassword'])->name('show.user.newpassword');
            Route::post('update/new-password/{id}', [App\Http\Controllers\Tukang\UserController::class, 'updateNewPassword'])->name('update.user.newpassword');
            Route::get('profile/change-photo', [App\Http\Controllers\Tukang\UserController::class, 'showChangePhoto'])->name('show.user.change.photo');
            Route::post('profile/upload/new-photo/{id}', [App\Http\Controllers\Tukang\UserController::class, 'updatePhotoUser'])->name('upload.user.photo');
        });
    });
});

Route::group(['prefix' => 'payment-gateway-testing'], function () {
    Route::get('/getBalance', [App\Http\Controllers\PaymentGateway\PembayaranController::class, 'getBalance']);
    Route::get('/createInvoice', [App\Http\Controllers\PaymentGateway\PembayaranController::class, 'createInvoice']);
    Route::get('/getInvoice/{id}', [App\Http\Controllers\PaymentGateway\PembayaranController::class, 'getInvoice']);
    Route::get('/getAllInvoice', [App\Http\Controllers\PaymentGateway\PembayaranController::class, 'getAllInvoice']);
    Route::get('/createPayout', [App\Http\Controllers\PaymentGateway\PembayaranController::class, 'createPayout']);
    Route::get('/getPayout/{id}', [App\Http\Controllers\PaymentGateway\PembayaranController::class, 'getPayout']);
    Route::get('/voidPayout/{id}', [App\Http\Controllers\PaymentGateway\PembayaranController::class, 'voidPayout']);
});
