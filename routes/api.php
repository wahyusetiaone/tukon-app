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
Route::post('register/admin-cabang/{hash}', 'App\Http\Controllers\API\UserController@registerAdminCabang')->name('register.admin-cabang');

Route::post('password/forgot-password', 'App\Http\Controllers\API\ForgotPasswordController@sendResetLinkResponse')->name('passwords.sent');
Route::post('password/reset', 'App\Http\Controllers\API\ResetPasswordController@sendResetResponse')->name('passwords.reset');

Route::group(['prefix' => 'guest', 'as' => 'guest'], function () {
    Route::get('beranda', 'App\Http\Controllers\API\BerandaController@index')->name('beranda');
    Route::get('new_product', 'App\Http\Controllers\API\BerandaController@new_product')->name('produk.terbaru');
    Route::get('new_productv2', 'App\Http\Controllers\API\BerandaController@new_productv2')->name('produk.terbaruv2');
    Route::get('top_tukang', 'App\Http\Controllers\API\BerandaController@top_tukang')->name('top.tukang');
    Route::get('location/{location}', 'App\Http\Controllers\API\BerandaController@filter_by_locationv2')->name('by.location');
    Route::group(['prefix' => 'search', 'as' => 'search'], function () {
        Route::post('produk', 'App\Http\Controllers\API\ProdukController@search')->name('produk');
        Route::post('new_product', 'App\Http\Controllers\API\BerandaController@search_new_product')->name('produk_terbaru');
        Route::post('top_tukang', 'App\Http\Controllers\API\BerandaController@search_top_tukang')->name('top.tukang');
        Route::post('location/{location}', 'App\Http\Controllers\API\BerandaController@search_by_locationv2')->name('by.location');
    });
    Route::group(['prefix' => 'helper', 'as' => 'helper'], function () {
        Route::get('kode_status', 'App\Http\Controllers\API\HelperGuestController@kode_status')->name('kode_status');
        Route::get('roles', 'App\Http\Controllers\API\HelperGuestController@roles')->name('roles');
        Route::get('plan_progress', 'App\Http\Controllers\API\HelperGuestController@plan_progress')->name('plan_progress');
    });
    Route::group(['prefix' => 'autocomplete', 'as' => 'autocomplete'], function () {
        Route::get('/{query}', 'App\Http\Controllers\API\AutoCompleteController@autocompleteproductwithnameoftukang')->name('autocompleteproductwithnameoftukang');
    });
    Route::group(['prefix' => 'tukang', 'as' => 'tukang'], function () {
        Route::get('all', 'App\Http\Controllers\API\TukangController@getAllTukang')->name('get.all.tukang');
        Route::get('details/{id}', 'App\Http\Controllers\API\TukangController@show')->name('show.tukang');
    });
    Route::group(['prefix' => 'produk', 'as' => 'produk'], function () {
        Route::get('all', 'App\Http\Controllers\API\ProdukController@getAllProduk')->name('get.all.produk');
        Route::get('all-by-tukang/{id}', 'App\Http\Controllers\API\ProdukController@getAllProdukByTukang')->name('get.all.produk.by.tukang');
        Route::get('details-t/{id}', 'App\Http\Controllers\API\ProdukController@getDetailsProdukWTukang')->name('details.produk.w.tukang');
    });
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('email/verify/{id}', 'App\Http\Controllers\API\VerificationApiController@verify')->name('verificationapi.verify');
    Route::get('email/verify/{id}/{hash}', 'App\Http\Controllers\API\VerificationApiController@verify_hash')->name('verificationapi.verify_hash');
    Route::get('email/resend', 'App\Http\Controllers\API\VerificationApiController@resend')->name('verificationapi.resend');

});

Route::group(['middleware' => ['auth:api', 'roles', 'verified:api']], function () {
    Route::get('details', 'App\Http\Controllers\API\UserController@details');
    Route::post('update', 'App\Http\Controllers\API\UserController@update');
    Route::post('upload_image', 'App\Http\Controllers\API\UserController@upload_image');

    Route::group(['prefix' => 'pdf'], function () {
        Route::group(['prefix' => 'offline'], function () {
            Route::get('bast/{id}', [App\Http\Controllers\Pdf\ApiPdfDomController::class, 'bast_offline'])->name('pdf.offline.bast');
            Route::get('surat-jalan/{id}', [App\Http\Controllers\Pdf\ApiPdfDomController::class, 'surat_jalan_offline'])->name('pdf.offline.surat_jalan');
            Route::get('penawaran/{id}', [App\Http\Controllers\Pdf\ApiPdfDomController::class, 'penawaran_offline'])->name('pdf.offline.penawaran');
        });
        Route::get('invoice/{id}', [App\Http\Controllers\Pdf\ApiPdfDomController::class, 'invoice'])->name('pdf.invoice');
        Route::get('bast/{id}', [App\Http\Controllers\Pdf\ApiPdfDomController::class, 'bast'])->name('pdf.bast');
        Route::get('penawaran/{id}', [App\Http\Controllers\Pdf\ApiPdfDomController::class, 'penawaran'])->name('pdf.penawaran');
        Route::get('surat-jalan/{id}', [App\Http\Controllers\Pdf\ApiPdfDomController::class, 'surat_jalan'])->name('pdf.surat_jalan');
    });
    Route::group(['prefix' => 'tukang', 'as' => 'tukang', 'roles' => 'tukang'], function () {
        Route::group(['prefix' => 'produk', 'as' => 'produk'], function () {
            Route::get('get', 'App\Http\Controllers\API\ProdukController@index')->name('get');
            Route::get('show/{id}', 'App\Http\Controllers\API\ProdukController@show')->name('show');
            Route::post('tambah', 'App\Http\Controllers\API\ProdukController@store')->name('tambah');
            Route::post('update', 'App\Http\Controllers\API\ProdukController@update')->name('update');
            Route::post('add/photo/{id}', 'App\Http\Controllers\API\ProdukController@add_photo')->name('add.photo');
            Route::post('update/photo/{id}', 'App\Http\Controllers\API\ProdukController@update_photo')->name('update.photo');
            Route::post('delete/photo/{id}', 'App\Http\Controllers\API\ProdukController@delete_photo')->name('delete.photo');
            Route::delete('hapus/{id}', 'App\Http\Controllers\API\ProdukController@destroy')->name('hapus');
            Route::post('search', 'App\Http\Controllers\API\ProdukController@search')->name('search');
        });
        Route::group(['prefix' => 'penawaran', 'as' => 'penawaran'], function () {
            Route::group(['prefix' => 'offline', 'as' => 'offline'], function () {
                Route::get('get', 'App\Http\Controllers\API\PenawaranOfflineController@index')->name('get');
                Route::post('add', 'App\Http\Controllers\API\PenawaranOfflineController@store')->name('add');
                Route::post('update/{id}', 'App\Http\Controllers\API\PenawaranOfflineController@update')->name('update');
                Route::get('delete/{id}', 'App\Http\Controllers\API\PenawaranOfflineController@destroy')->name('delete');
                Route::get('show/{id}', 'App\Http\Controllers\API\PenawaranOfflineController@show')->name('show');
            });
            Route::get('get', 'App\Http\Controllers\API\PenawaranController@index')->name('get');
            Route::get('show/{id}', 'App\Http\Controllers\API\PenawaranController@show')->name('show');
            Route::post('add', 'App\Http\Controllers\API\PenawaranController@create')->name('add');
            Route::post('update/{id}', 'App\Http\Controllers\API\PenawaranController@update')->name('update');
            Route::delete('remove/{id}', 'App\Http\Controllers\API\PenawaranController@destroy')->name('remove');
            Route::post('updatev2/{id}', 'App\Http\Controllers\API\PenawaranController@updatev2')->name('updatev2');
            Route::delete('komponen/remove/{id}', 'App\Http\Controllers\API\PenawaranController@destroy_komponen')->name('komponen.remove');
            Route::post('komponen/update/{id}', 'App\Http\Controllers\API\PenawaranController@update_komponen')->name('komponen.update');
        });
        Route::group(['prefix' => 'persetujuan', 'as' => 'persetujuan'], function () {
            Route::get('accept/{id}', 'App\Http\Controllers\API\PersetujuanController@accept_tukang')->name('accpet_tukang');
        });
        Route::group(['prefix' => 'progress', 'as' => 'progress'], function () {
            Route::post('upload/{id}', 'App\Http\Controllers\API\ProgressController@create')->name('upload');
        });
        Route::group(['prefix' => 'project', 'as' => 'project'], function () {
            Route::get('get', 'App\Http\Controllers\API\ProjectController@tukang_get_all_project')->name('tukang_all_project');
            Route::get('lihat/{id}', 'App\Http\Controllers\API\ProjectController@tukang_show_project')->name('tukang_show_project');
            Route::get('konfirmasi/selesai/{id}', 'App\Http\Controllers\API\ProjectController@tukang_approve')->name('client_approve');
        });
        Route::group(['prefix' => 'pengajuan', 'as' => 'pengajuan'], function () {
            Route::get('/', 'App\Http\Controllers\API\PengajuanController@pengajuan_base_tukang')->name('pengajuan_base_tukang');
            Route::get('/show/{id}', 'App\Http\Controllers\API\PengajuanController@show_pengajuan_base_tukang')->name('show_pengajuan_base_tukang');
            Route::get('tolak/{id}', 'App\Http\Controllers\API\PengajuanController@tolak_pengajuan')->name('tolak_pengajuan');
        });
        Route::group(['prefix' => 'bpa', 'as' => 'bpa'], function () {
            Route::get('active', 'App\Http\Controllers\API\BPAController@index')->name('bpa.active');
            Route::get('check/{id}', 'App\Http\Controllers\API\BPAController@check')->name('bpa.check');

        });
        Route::group(['prefix' => 'penarikan', 'as' => 'penarikan'], function () {
            Route::get('get', 'App\Http\Controllers\API\PenarikanDanaController@index')->name('get');
            Route::get('get/{id}', 'App\Http\Controllers\API\PenarikanDanaController@indexTukang')->name('get');
            Route::get('avaliable/{id}', 'App\Http\Controllers\API\PenarikanDanaController@create')->name('avaliable');
            Route::post('ajukan/{id}/{persen}', 'App\Http\Controllers\API\PenarikanDanaController@store')->name('ajukan.penarikan.dana');
        });
        Route::group(['prefix' => 'notification'], function () {
            Route::get('show', [App\Http\Controllers\API\NotificationController::class, 'index'])->name('notif.show');
            Route::get('mark/{id}', [App\Http\Controllers\API\NotificationController::class, 'markReaded'])->name('notif.mark.readed');
        });
        Route::group(['prefix' => 'sistem-penarikan-dana', 'as' => 'sistem_penarikan_dana'], function () {
            Route::get('get', [App\Http\Controllers\API\SistemPenarikanDanaController::class, 'index'])->name('get.spd');
        });
    });

    Route::group(['prefix' => 'client', 'as' => 'client', 'roles' => 'klien'], function () {
        Route::get('get-rate/{kode_project}', 'App\Http\Controllers\API\RatingController@get')->name('get_it');
        Route::post('rate-it/{kode_project}', 'App\Http\Controllers\API\RatingController@send')->name('send_it');
        Route::post('change-rate/{id}', 'App\Http\Controllers\API\RatingController@change')->name('change-it');

        Route::group(['prefix' => 'wishlist', 'as' => 'wishlist'], function () {
            Route::get('get', 'App\Http\Controllers\API\WishlistController@index')->name('get');
            Route::post('remove', 'App\Http\Controllers\API\WishlistController@remove')->name('remove');
            Route::post('add', 'App\Http\Controllers\API\WishlistController@add')->name('add');
        });
        Route::group(['prefix' => 'pengajuan', 'as' => 'pengajuan'], function () {
            Route::get('get', 'App\Http\Controllers\API\PengajuanController@index')->name('get');
            Route::post('add', 'App\Http\Controllers\API\PengajuanController@create')->name('add');
            Route::post('wishlist/add', 'App\Http\Controllers\API\PengajuanController@createformwishlist')->name('add.wishlist');
            Route::delete('remove/{id}', 'App\Http\Controllers\API\PengajuanController@destroy')->name('remove');
            Route::post('update/{id}', 'App\Http\Controllers\API\PengajuanController@update')->name('update');
            Route::post('remove/photo/{id}', 'App\Http\Controllers\API\PengajuanController@destroy_photo')->name('remove.photo');
            Route::post('remove/tukang/{id}', 'App\Http\Controllers\API\PengajuanController@destroy_tukang')->name('remove.tukang');
            Route::get('tukang/by/{kode_pengajuan}', 'App\Http\Controllers\API\PengajuanController@get_tukang_by_pengajuan')->name('tukang.by.pengajuan');
            Route::get('batal/{id}', 'App\Http\Controllers\API\PengajuanController@batal_pengajuan')->name('batal.pengajuan');
            Route::post('add/berkas/{id}', 'App\Http\Controllers\API\PengajuanController@addBerkas')->name('add.berkas.pengajuan');
            Route::post('remove/berkas/{id}', 'App\Http\Controllers\API\PengajuanController@removeBerkas')->name('remove.berkas.pengajuan');
            Route::get('/show/{id}', 'App\Http\Controllers\API\PengajuanController@show_pengajuan_base_client')->name('show_pengajuan_base_client');
        });
        Route::group(['prefix' => 'penawaran', 'as' => 'penawaran'], function () {
            Route::get('show/{id}', 'App\Http\Controllers\API\PenawaranController@showclient')->name('penawaran.show.client');
        });
        Route::group(['prefix' => 'persetujuan', 'as' => 'persetujuan'], function () {
            Route::get('accept/{id}', 'App\Http\Controllers\API\PersetujuanController@accept_client')->name('accpet_client');
            Route::post('revisi/{id}', 'App\Http\Controllers\API\PersetujuanController@revisi_client')->name('revisi_client');
        });
        Route::group(['prefix' => 'pembayaran', 'as' => 'pembayaran'], function () {
            Route::get('get', 'App\Http\Controllers\API\PembayaranController@index')->name('get');
            Route::get('tagihan', 'App\Http\Controllers\API\PembayaranController@tagihan')->name('tagihan');
            Route::get('lihat/tagihan/{id}', 'App\Http\Controllers\API\PembayaranController@show')->name('lihat_tagihan');
            Route::get('lihat/pembayaran/{id}', 'App\Http\Controllers\API\PembayaranController@show')->name('lihat_pembayaran');
            Route::post('upload/{id}', 'App\Http\Controllers\API\PembayaranController@create')->name('upload');
            Route::post('reupload/{id}', 'App\Http\Controllers\API\PembayaranController@create')->name('reupload');
            Route::get('batal/{id}', 'App\Http\Controllers\API\PembayaranController@cancel')->name('cancel');
            Route::get('available/payment-channel', 'App\Http\Controllers\API\PembayaranController@availablePayChannel')->name('available.payment.channel');
            Route::post('checkout/{id}', 'App\Http\Controllers\API\PembayaranController@checkOut')->name('checkout');
            Route::get('invoice/status/{id}', 'App\Http\Controllers\API\PembayaranController@viewInvoice')->name('show.invoice');
        });
        Route::group(['prefix' => 'project', 'as' => 'project'], function () {
            Route::get('get', 'App\Http\Controllers\API\ProjectController@client_show_all_project')->name('client_show_all_project');
            Route::get('lihat/{id}', 'App\Http\Controllers\API\ProjectController@client_show_project')->name('client_show_project');
            Route::get('konfirmasi/selesai/{id}', 'App\Http\Controllers\API\ProjectController@client_approve')->name('client_approve');
            Route::get('batal/{id}', 'App\Http\Controllers\API\ProjectController@client_cancel')->name('client_cancel');
        });
        Route::group(['prefix' => 'penarikan', 'as' => 'penarikan'], function () {
            Route::get('get/{id}', 'App\Http\Controllers\API\PenarikanDanaController@indexClient')->name('get');
            Route::get('terima/{id}/{transaksi}', 'App\Http\Controllers\API\PenarikanDanaController@terima')->name('terima');
            Route::get('tolak/{id}/{transaksi}', 'App\Http\Controllers\API\PenarikanDanaController@tolak')->name('tolak');
        });
        Route::group(['prefix' => 'avaliable-bank', 'as' => 'avaliable-bank'], function () {
            Route::get('get', 'App\Http\Controllers\API\AvaliableBankAccountController@index')->name('get');
        });
        Route::group(['prefix' => 'pengembalian-dana', 'as' => 'pengembalian-dana'], function () {
            Route::get('get', 'App\Http\Controllers\API\PengembalianDanaController@index')->name('get');
            Route::post('ajukan/{id}', 'App\Http\Controllers\API\PengembalianDanaController@ajukan')->name('ajukan');
            Route::get('show/{id}', 'App\Http\Controllers\API\PengembalianDanaController@show')->name('show');
        });
        Route::group(['prefix' => 'notification'], function () {
            Route::get('show', [App\Http\Controllers\API\NotificationController::class, 'index'])->name('notif.show');
            Route::get('mark/{id}', [App\Http\Controllers\API\NotificationController::class, 'markReaded'])->name('notif.mark.readed');
        });
    });

    Route::group(['prefix' => 'admin-cabang', 'as' => 'admin-cabang', 'roles' => 'admin'], function () {
        Route::group(['prefix' => 'cabang'], function () {
            Route::get('/', [App\Http\Controllers\API\AdminCabang\CabangController::class, 'index'])->name('all.cabang.admincabang');
            Route::get('get/{idcabang}', [App\Http\Controllers\API\AdminCabang\CabangController::class, 'getTukangFromCabang'])->name('all.tukang.cabang.admincabang');
        });
        Route::group(['prefix' => 'tukang'], function () {
            Route::get('show/{id}', [App\Http\Controllers\API\AdminCabang\TukangController::class, 'show'])->name('show.tukang.admincabang');
        });
        Route::group(['prefix' => 'verification'], function () {
            Route::post('ajukan/{id}', [App\Http\Controllers\API\AdminCabang\VerificationController::class, 'ajukan_verification'])->name('ajukan.verification.admincabang');
        });
        Route::group(['prefix' => 'bonus'], function () {
            Route::get('/', [App\Http\Controllers\API\AdminCabang\BonusController::class, 'index'])->name('get.bonus.admincabang');
            Route::get('ajukan/{id}', [App\Http\Controllers\API\AdminCabang\BonusController::class, 'ajukan'])->name('ajukan.bonus.admincabang');
        });
        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('/', [App\Http\Controllers\API\AdminCabang\DashboardController::class, 'index'])->name('dashboard.admincabang');
        });
    });
    if (env('DEV_MODE', true)) {
        Route::group(['prefix' => 'admin', 'as' => 'admin', 'roles' => 'su'], function () {
            Route::post('pembayaran/accept/{id}', 'App\Http\Controllers\API\AdminPembayaranController@accept')->name('accept');
            Route::post('pembayaran/reject/{id}', 'App\Http\Controllers\API\AdminPembayaranController@reject')->name('reject');
        });
    }
});
