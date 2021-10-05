<?php

use App\Events\PengajuanEventController;
use App\Events\PrivateChannelTest;
use App\Models\NotificationHandler;
use App\Models\Penawaran;
use App\Models\Pin;
use Dompdf\Dompdf;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Xendit\Xendit;

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

Route::group(['prefix' => 'command'], function () {

    Route::get('run-migrations-force', function () {
        return Artisan::call('migrate', ["--force" => true]);
        return '<h1>Migrate Database</h1>';
    });
    //Clear Config cache:
    Route::get('run-migrations', function () {
        return Artisan::call('migrate');
        return '<h1>Migrate Database</h1>';
    });
//Clear Cache facade value:
    Route::get('clear-cache', function () {
        $exitCode = Artisan::call('cache:clear');
        return '<h1>Cache facade value cleared</h1>';
    });
//Reoptimized class loader:
    Route::get('optimize', function () {
        $exitCode = Artisan::call('optimize');
        return '<h1>Reoptimized class loader</h1>';
    });
//Route cache:
    Route::get('route-cache', function () {
        $exitCode = Artisan::call('route:cache');
        return '<h1>Routes cached</h1>';
    });
//Clear Route cache:
    Route::get('route-clear', function () {
        $exitCode = Artisan::call('route:clear');
        return '<h1>Route cache cleared</h1>';
    });
//Clear View cache:
    Route::get('view-clear', function () {
        $exitCode = Artisan::call('view:clear');
        return '<h1>View cache cleared</h1>';
    });
//Clear Config cache:
    Route::get('config-cache', function () {
        $exitCode = Artisan::call('config:cache');
        return '<h1>Clear Config cleared</h1>';
    });
    //Clear Config cache:
    Route::get('passport-install', function () {
        $exitCode = Artisan::call('passport:install');
        return '<h1>Passport Successfuly Installed</h1>';
    });
    //Clear key-generate:
    Route::get('key-generate', function () {
        $exitCode = Artisan::call('key:generate');
        return '<h1>Generated Key Successfuly Installed</h1>';
    });
    //Clear db:seed:
    Route::get('db-seed', function () {
        $exitCode = Artisan::call('db:seed');
        return '<h1>Seeder Successfuly Run</h1>';
    });
});

Route::group(['prefix' => 'trigger'], function () {
    Route::get('/kirim-email', [\App\Http\Controllers\Email\EmailController::class, 'index']);
    Route::get('dummy', function () {
        $dompdf = new Dompdf();
        $dompdf->loadHtml('<p>Hello world</p>');
        $dompdf->render();
        $canvas = $dompdf->getCanvas();
        $canvas->page_script('
  $pdf->set_opacity(.5);
  $pdf->image("https://cdn.sstatic.net/Img/teams/teams-illo-free-sidebar-promo.svg?v=47faa659a05e", {x}, {y}, {w}, {h});
');
        return $dompdf->stream('docu.pdf');
    });
    Route::get('bisayokbisa', function () {

        // want to broadcast PrivateChannelTest event
//        $msg = new NotificationHandler();
//        $msg->user_id = 8;
//        $msg->title = "Proyek";
//        $msg->message = "Proyek Telah Selesai";
//        $msg->name = "Buat Rumah";
//        $msg->deep_id = 12;
//        $msg->role = "client"; //client/tukang/admin
//        $msg->action = "update"; //add/cancel/update
//        $msg->read = false;
//        $msg->save();
//        $unReadNotif = NotificationHandler::select('id')->where('user_id', 8)->count();
//        broadcast(new PrivateChannelTest($msg,$unReadNotif));
//        bringInNotification($msg, $unReadNotif, \App\Events\ProyekEventController::eventCreated());
////

//       \App\Models\Pin::find(2)->update(['status' => 'B01']);
//
//$data = Penawaran::with('pin.pengajuan')->get()->toArray();
//var_dump($data);
//        Xendit::setApiKey('xnd_development_Ktc4xiPAIzWUqGG9ipjzB70DXOq5xme2lnm7IprztogsNF1TrXQPLON2J1bp0');
//
//        $ovoParams = [
//            'external_id' => 'demo_147580196270',
//            'amount' => 32000,
//            'phone' => '081298498259',
//            'ewallet_type' => 'OVO'
//        ];
//
//        $danaParams = [
//            'external_id' => 'demo_' . time(),
//            'amount' => 32000,
//            'phone' => '081298498259',
//            'expiration_date' => '2100-02-20T00:00:00.000Z',
//            'callback_url' => 'https://my-shop.com/callbacks',
//            'redirect_url' => 'https://my-shop.com/home',
//            'ewallet_type' => 'DANA'
//        ];
//
//        $linkajaParams = [
//            'external_id' => 'demo_' . time(),
//            'amount' => 32000,
//            'phone' => '081298498259',
//            'items' => [
//                [
//                    'id' => '123123',
//                    'name' => 'Phone Case',
//                    'price' => 100000,
//                    'quantity' => 1
//                ],
//                [
//                    'id' => '345678',
//                    'name' => 'Powerbank',
//                    'price' => 200000,
//                    'quantity' => 1
//                ]
//            ],
//            'callback_url' => 'https =>//yourwebsite.com/callback',
//            'redirect_url' => 'https =>//yourwebsite.com/order/123',
//            'ewallet_type' => 'LINKAJA'
//        ];
//
//        $ewalletChargeParams = [
//            'reference_id' => 'invoice-41628124856',
//            'currency' => 'IDR',
//            'amount' => 80006,
//            'checkout_method' => 'ONE_TIME_PAYMENT',
//            'channel_code' => 'ID_OVO',
//            'channel_properties' => [
//                'mobile_number' => '+628789098900',
//            ],
//            'metadata' => [
//                'meta' => 'data'
//            ]
//        ];

//        try {
//            $createOvo = \Xendit\EWallets::create($ovoParams);
//            var_dump($createOvo);
//        } catch (\Xendit\Exceptions\ApiException $exception) {
//            var_dump($exception);
//        }
//
//        $createDana = \Xendit\EWallets::create($danaParams);
//        var_dump($createDana);
//
//        $createLinkaja = \Xendit\EWallets::create($linkajaParams);
//        var_dump($createLinkaja);
//
//        $getOvo = \Xendit\EWallets::getPaymentStatus($ovoParams['external_id'], 'OVO');
//        var_dump($getOvo);
//
//        $getDana = \Xendit\EWallets::getPaymentStatus($danaParams['external_id'], 'DANA');
//        var_dump($getDana);
//
//        $getLinkaja = \Xendit\EWallets::getPaymentStatus(
//            $linkajaParams['external_id'],
//            'LINKAJA'
//        );
//        var_dump($getLinkaja);
//
//        echo "Creating E-Wallet Charge...\n";
//        $createEWalletCharge = \Xendit\EWallets::createEWalletCharge($ewalletChargeParams);
//        var_dump($createEWalletCharge);
//
//        echo "Retrieving E-Wallet Charge Status with ID: {$createEWalletCharge['id']}...\n";
//        $getEWalletChargeStatus = \Xendit\EWallets::getEWalletChargeStatus(
//            $createEWalletCharge['id']
//        );
//        var_dump($getEWalletChargeStatus);

        $data = \App\Models\Invoice::where('kode_pembayaran', 1)->first();
        $data->status = 'PAID';
        $data->save();

        return '<h1>Yokk Event Trigger :</h1>';
    });
});

Route::group(['prefix' => '/callback/xendit/log'], function () {
    Route::post('fva/{event}', [\App\Http\Controllers\PaymentGateway\LogController::class, 'fva'])
        ->name('log.fva')
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('retail', [\App\Http\Controllers\PaymentGateway\LogController::class, 'retail'])
        ->name('log.retail')
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('invoice', [\App\Http\Controllers\PaymentGateway\LogController::class, 'invoice'])
        ->name('log.invoice')
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('ewallet', [\App\Http\Controllers\PaymentGateway\LogController::class, 'ewallet'])
        ->name('log.ewallet')
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
});

Route::get('/helper', [\App\Http\Controllers\HelperView::class, 'index'])->name('helperview');
Route::get('/', [App\Http\Controllers\HomeClientController::class, 'index'])->name('/');
Route::get('search/{fiter}/{search}', [App\Http\Controllers\Client\SearchController::class, 'index'])->name('search');
Route::get('get/kota/{id}', [App\Http\Controllers\Client\SearchController::class, 'getKota'])->name('search.get.kota');

Route::group(['prefix' => 'pdf'], function () {
    Route::group(['prefix' => 'pdf'], function () {
        Route::get('penawaran/{id}', [App\Http\Controllers\Pdf\PdfDomController::class, 'penawaran_offline'])->name('pdf.offline.penawaran');
    });
    Route::get('invoice/{id}', [App\Http\Controllers\Pdf\PdfDomController::class, 'invoice'])->name('pdf.invoice');
    Route::get('bast/{id}', [App\Http\Controllers\Pdf\PdfDomController::class, 'bast'])->name('pdf.bast');
    Route::get('penawaran/{id}', [App\Http\Controllers\Pdf\PdfDomController::class, 'penawaran'])->name('pdf.penawaran');
    Route::get('surat-jalan/{id}', [App\Http\Controllers\Pdf\PdfDomController::class, 'surat_jalan'])->name('pdf.surat_jalan');
});

Route::group(['prefix' => 'panel'], function () {
    Route::get('login', function (){
        return view('auth.panel.login_panel');
    })->name('panel.login');

    Route::get('/{as}/login', function (){
        return view('auth.panel.login');
    })->name('panel.login.as');

    Route::get('register', function (){
        return view('auth.panel.register_panel');
    })->name('panel.register');

    Route::get('/{as}/register', function (){
        return view('auth.panel.register');
    })->name('panel.register.as');

    Route::post('register/check', [App\Http\Controllers\Auth\RegisterController::class, 'checkEmail'])->name('register.check');
});

Route::get('forbiden-mobile-view', function () {
    return view('mobile.app_mobile');
});

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

//route verifikasi email
Auth::routes(['verify' => true]);
//replace verify email to custom view
Route::get('/email/verify', function () {
    return view('auth.panel.verify');
})->middleware('auth')->name('verification.notice');
//verify successfully custom view
Route::get('/verification-successfully', function () {
    return view('auth.verify.success');
})->middleware('auth')->name('verification.successfully');
Route::get('/reset-password-successfully', function () {
    return view('auth.passwords.successfully_reset_password');
})->middleware('auth')->name('password.reset.successfully');

Route::group(['middleware' => ['auth', 'roles', 'verified']], function () {
    Route::group(['prefix' => 'client', 'roles' => 'klien'], function () {
        Route::get('home', [App\Http\Controllers\HomeClientController::class, 'index'])->name('homeclient');
        Route::get('wishlist', [App\Http\Controllers\Client\WishlistController::class, 'index'])->name('wishlist');
        Route::get('pengajuan', [App\Http\Controllers\Client\PengajuanController::class, 'index'])->name('pengajuan.client');
        Route::get('penawaran', [App\Http\Controllers\Client\PenawaranController::class, 'index'])->name('penawaran.client');
        Route::get('project', [App\Http\Controllers\Client\ProjectController::class, 'index'])->name('project.client');
        Route::get('pembayaran', [App\Http\Controllers\Client\PembayaranController::class, 'index'])->name('pembayaran.client');
        Route::get('pengembalian-dana', [App\Http\Controllers\Client\PengembalianDanaController::class, 'index'])->name('pengembalian-dana.client');

//        Route::get('search/{filter}/{search}', [App\Http\Controllers\Client\SearchController::class, 'index'])->name('search');
        Route::group(['prefix' => 'notification'], function () {
            Route::get('all', [App\Http\Controllers\Client\NotificationController::class, 'index'])->name('notification.client');
            Route::get('read/{id}/{deep_id}/{what}', [App\Http\Controllers\Client\NotificationController::class, 'read'])->name('notification.client.read');
            Route::get('count/{id}', [App\Http\Controllers\Client\NotificationController::class, 'countNotification'])->name('notification.client.count');
        });
        Route::group(['prefix' => 'wishlist'], function () {
            Route::get('add/{id}', [App\Http\Controllers\Client\WishlistController::class, 'create'])->name('add.wishlist');
            Route::get('remove/{id}', [App\Http\Controllers\Client\WishlistController::class, 'destroy'])->name('remove.wishlist');
        });
        Route::group(['prefix' => 'pengajuan'], function () {
            Route::get('form/{tukang}', [App\Http\Controllers\Client\PengajuanController::class, 'create'])->name('add.pengajuan.client');
            Route::post('store/{id}/{multi}/{kode_tukang}', [App\Http\Controllers\Client\PengajuanController::class, 'store'])->name('store.pengajuan.client');
            Route::get('show/{id}', [App\Http\Controllers\Client\PengajuanController::class, 'show'])->name('show.pengajuan.client');
            Route::get('edit/{id}', [App\Http\Controllers\Client\PengajuanController::class, 'edit'])->name('edit.pengajuan.client');
            Route::post('update/{id}', [App\Http\Controllers\Client\PengajuanController::class, 'update'])->name('update.pengajuan.client');
            Route::post('delete/image/{id}', [App\Http\Controllers\Client\PengajuanController::class, 'removeImg'])->name('remove.pengajuan.client.photo');
            Route::post('add/image/{id}', [App\Http\Controllers\Client\PengajuanController::class, 'addImg'])->name('add.pengajuan.client.photo');
            Route::get('check-safe-args/{id}', [App\Http\Controllers\Client\PengajuanController::class, 'checkSafetyDelete'])->name('checksafeargs.pengajuan.client');
            Route::get('delete/{id}', [App\Http\Controllers\Client\PengajuanController::class, 'destroy'])->name('delete.pengajuan.client');
            Route::post('delete/berkas/{id}', [App\Http\Controllers\Client\PengajuanController::class, 'removeBerkas'])->name('remove.pengajuan.client.berkas');
            Route::post('add/berkas/{id}', [App\Http\Controllers\Client\PengajuanController::class, 'addBerkas'])->name('add.pengajuan.client.berkas');
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
            Route::get('bayar/{id}', [App\Http\Controllers\Client\PembayaranController::class, 'bayar'])->name('bayar.pembayaran.client');
            Route::post('checkout/{id}', [App\Http\Controllers\Client\PembayaranController::class, 'checkOut'])->name('checkout.pembayaran.client');
            Route::get('show/invoice/{id}', [App\Http\Controllers\Client\PembayaranController::class, 'viewInvoice'])->name('invoice.pembayaran.client');
            Route::get('pay/offline/{id}', [App\Http\Controllers\Client\PembayaranController::class, 'createOffline'])->name('payoffline.pembayaran.client');
            Route::post('pay/offline/store/{id}', [App\Http\Controllers\Client\PembayaranController::class, 'storeOffline'])->name('store.payoffline.pembayaran.client');
            Route::get('pay/online/{id}', [App\Http\Controllers\Client\PembayaranController::class, 'createOnline'])->name('payonline.pembayaran.client');
            Route::get('batal/{id}', [App\Http\Controllers\Client\PembayaranController::class, 'cancel'])->name('batal.pembayaran.client');
        });
        Route::group(['prefix' => 'project'], function () {
            Route::get('show/{id}', [App\Http\Controllers\Client\ProjectController::class, 'show'])->name('show.project.client');
            Route::get('approve/{id}', [App\Http\Controllers\Client\ProjectController::class, 'client_approve'])->name('client_approve.projek');
            Route::get('batal/{id}', [App\Http\Controllers\Client\ProjectController::class, 'client_cancel'])->name('client_cancle.projek');
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
        Route::group(['prefix' => 'pengembalian-dana'], function () {
            Route::get('show/{id}', [App\Http\Controllers\Client\PengembalianDanaController::class, 'show'])->name('show.pengembalian-dana.client');
            Route::post('ajukan', [App\Http\Controllers\Client\PengembalianDanaController::class, 'store'])->name('ajukan.pengembalian-dana.client');
        });
    });

    //tukang
    Route::group(['roles' => ['superadmin', 'tukang']], function () {
        Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('produk', [App\Http\Controllers\Tukang\ProdukController::class, 'index'])->name('produk');
        Route::get('produk/add', [App\Http\Controllers\Tukang\ProdukController::class, 'create'])->name('add.produk');
        Route::post('produk/store', [App\Http\Controllers\Tukang\ProdukController::class, 'store'])->name('store.produk');
        Route::get('produk/show', [App\Http\Controllers\Tukang\ProdukController::class, 'show'])->name('show.produk');
        Route::post('produk/update/{id}', [App\Http\Controllers\Tukang\ProdukController::class, 'update'])->name('update.produk');
        Route::get('produk/delete/{id}', [App\Http\Controllers\Tukang\ProdukController::class, 'destroy'])->name('destroy.produk');
        Route::get('produk/json', [App\Http\Controllers\Tukang\ProdukController::class, 'json'])->name('data.produk.json');
        Route::post('produk/delete/image/{id}', [App\Http\Controllers\Tukang\ProdukController::class, 'removeImg'])->name('remove.produk.photo');
        Route::post('produk/add/image/{id}', [App\Http\Controllers\Tukang\ProdukController::class, 'addImg'])->name('add.produk.photo');

        Route::group(['prefix' => 'notification'], function () {
            Route::get('all', [App\Http\Controllers\Tukang\NotificationController::class, 'index'])->name('notification');
            Route::get('read/{id}/{deep_id}/{what}', [App\Http\Controllers\Tukang\NotificationController::class, 'read'])->name('notification.read');
            Route::get('count/{id}', [App\Http\Controllers\Tukang\NotificationController::class, 'countNotification'])->name('notification.count');
        });
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
    //admin
    Route::group(['prefix' => 'su', 'roles' => 'superadmin'], function () {
        Route::group(['prefix' => 'pembayaran'], function () {
            Route::get('/', [App\Http\Controllers\Admin\PembayaranController::class, 'index'])->name('pembayaran.admin');
            Route::get('json', [App\Http\Controllers\Admin\PembayaranController::class, 'json'])->name('data.pembayaran.json.admin');
            Route::get('show/{id}', [App\Http\Controllers\Admin\PembayaranController::class, 'show'])->name('show.pembayaran.admin');
            Route::post('terima/{id}', [App\Http\Controllers\Admin\PembayaranController::class, 'accept'])->name('accept.pembayaran.admin');
            Route::post('tolak/{id}', [App\Http\Controllers\Admin\PembayaranController::class, 'reject'])->name('reject.pembayaran.admin');
        });
        Route::group(['prefix' => 'penawaran'], function () {
            Route::get('/', [App\Http\Controllers\Admin\PenawaranController::class, 'index'])->name('penawaran.admin');
            Route::get('json', [App\Http\Controllers\Admin\PenawaranController::class, 'json'])->name('data.penawaran.json.admin');
            Route::get('show/{id}', [App\Http\Controllers\Admin\PenawaranController::class, 'show'])->name('show.penawaran.admin');
        });
        Route::group(['prefix' => 'pengajuan'], function () {
            Route::get('/', [App\Http\Controllers\Admin\PengajuanController::class, 'index'])->name('pengajuan.admin');
            Route::get('json', [App\Http\Controllers\Admin\PengajuanController::class, 'json'])->name('data.pengajuan.json.admin');
            Route::get('show/{id}', [App\Http\Controllers\Admin\PengajuanController::class, 'show'])->name('show.pengajuan.admin');
        });
        Route::group(['prefix' => 'verification-tukang'], function () {
            Route::get('/', [App\Http\Controllers\Admin\VerificationTukangController::class, 'index'])->name('verification-tukang.admin');
            Route::get('json', [App\Http\Controllers\Admin\VerificationTukangController::class, 'json'])->name('data.verification-tukang.json.admin');
            Route::get('show/{id}', [App\Http\Controllers\Admin\VerificationTukangController::class, 'show'])->name('show.verification-tukang.admin');
            Route::get('verifikasi/terima/{id}', [App\Http\Controllers\Admin\VerificationTukangController::class, 'verifikasi'])->name('terima.verification-tukang.admin');
            Route::post('verifikasi/tolak/{id}', [App\Http\Controllers\Admin\VerificationTukangController::class, 'tolak'])->name('tolak.verification-tukang.admin');
        });
        Route::group(['prefix' => 'user'], function () {
            Route::group(['prefix' => 'klien'], function () {
                Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'indexclient'])->name('pengguna.client.admin');
                Route::get('json', [App\Http\Controllers\Admin\UserController::class, 'jsonclient'])->name('data.pengguna.client.json.admin');
                Route::get('show/{id}', [App\Http\Controllers\Admin\UserController::class, 'showclient'])->name('show.pengguna.client.admin');
            });
            Route::group(['prefix' => 'tukang'], function () {
                Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'indextukang'])->name('pengguna.tukang.admin');
                Route::get('json', [App\Http\Controllers\Admin\UserController::class, 'jsontukang'])->name('data.pengguna.tukang.json.admin');
                Route::get('show/{id}', [App\Http\Controllers\Admin\UserController::class, 'showtukang'])->name('show.pengguna.tukang.admin');
            });
            Route::group(['prefix' => 'admin-cabang'], function () {
                Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'indexadmin'])->name('pengguna.admincabang.admin');
                Route::get('json', [App\Http\Controllers\Admin\UserController::class, 'jsonadmin'])->name('data.pengguna.admincabang.json.admin');
                Route::get('show/{id}', [App\Http\Controllers\Admin\UserController::class, 'showtukang'])->name('show.pengguna.admincabang.admin');
                Route::get('add', [App\Http\Controllers\Admin\UserController::class, 'addadmin'])->name('add.pengguna.admincabang.admin');
                Route::post('store', [App\Http\Controllers\Admin\UserController::class, 'storeadmin'])->name('store.pengguna.admincabang.admin');
            });
            Route::post('banned/{id}', [App\Http\Controllers\Admin\BanController::class, 'banned'])->name('pengguna.banned.admin');
            Route::get('unbanned/{id}', [App\Http\Controllers\Admin\BanController::class, 'unbanned'])->name('pengguna.unbanned.admin');
        });
        Route::group(['prefix' => 'penarikan-dana'], function () {
            Route::get('/', [App\Http\Controllers\Admin\PenarikanDanaController::class, 'index'])->name('penarikan.admin');
            Route::get('json', [App\Http\Controllers\Admin\PenarikanDanaController::class, 'json'])->name('data.penarikan.json.admin');
            Route::get('show/{id}', [App\Http\Controllers\Admin\PenarikanDanaController::class, 'show'])->name('show.penarikan.admin');
            Route::get('konfirmasi-terima/{id}', [App\Http\Controllers\Admin\PenarikanDanaController::class, 'acceptShow'])->name('accept.show.penarikan.admin');
            Route::get('konfirmasi-tolak/{id}', [App\Http\Controllers\Admin\PenarikanDanaController::class, 'rejectShow'])->name('reject.show.penarikan.admin');
            Route::post('terima', [App\Http\Controllers\Admin\PenarikanDanaController::class, 'accept'])->name('accept.penarikan.admin');
            Route::post('tolak', [App\Http\Controllers\Admin\PenarikanDanaController::class, 'reject'])->name('reject.penarikan.admin');
        });
        Route::group(['prefix' => 'pengembalian-dana'], function () {
            Route::get('/', [App\Http\Controllers\Admin\PengembalianDanaController::class, 'index'])->name('pengembalian-dana.admin');
            Route::get('json', [App\Http\Controllers\Admin\PengembalianDanaController::class, 'json'])->name('data.pengembalian-dana.json.admin');
            Route::get('show/{id}', [App\Http\Controllers\Admin\PengembalianDanaController::class, 'show'])->name('show.pengembalian-dana.admin');
            Route::get('konfirmasi-terima/{id}', [App\Http\Controllers\Admin\PengembalianDanaController::class, 'acceptShow'])->name('accept.show.pengembalian-dana.admin');
            Route::get('konfirmasi-tolak/{id}', [App\Http\Controllers\Admin\PengembalianDanaController::class, 'rejectShow'])->name('reject.show.pengembalian-dana.admin');
            Route::post('terima', [App\Http\Controllers\Admin\PengembalianDanaController::class, 'accept'])->name('accept.pengembalian-dana.admin');
            Route::post('tolak', [App\Http\Controllers\Admin\PengembalianDanaController::class, 'reject'])->name('reject.pengembalian-dana.admin');
        });
        Route::group(['prefix' => 'pengaturan'], function () {
            Route::group(['prefix' => 'bpa'], function () {
                Route::get('/', [App\Http\Controllers\Admin\BPAController::class, 'index'])->name('pengaturan.bpa.index.admin');
                Route::get('json', [App\Http\Controllers\Admin\BPAController::class, 'json'])->name('pengaturan.bpa.json.admin');
                Route::post('update', [App\Http\Controllers\Admin\BPAController::class, 'update'])->name('pengaturan.bpa.update.admin');
            });
        });

        Route::group(['prefix' => 'pencairan-bonus'], function () {
            Route::get('/', [App\Http\Controllers\Admin\PencairanBonusController::class, 'index'])->name('pencairan.admin');
            Route::get('json', [App\Http\Controllers\Admin\PencairanBonusController::class, 'json'])->name('data.pencairan.json.admin');
            Route::get('show/{id}', [App\Http\Controllers\Admin\PencairanBonusController::class, 'show'])->name('show.pencairan.admin');
            Route::get('konfirmasi-terima/{id}', [App\Http\Controllers\Admin\PencairanBonusController::class, 'acceptShow'])->name('accept.show.pencairan.admin');
            Route::get('konfirmasi-tolak/{id}', [App\Http\Controllers\Admin\PencairanBonusController::class, 'rejectShow'])->name('reject.show.pencairan.admin');
            Route::post('terima', [App\Http\Controllers\Admin\PencairanBonusController::class, 'accept'])->name('accept.pencairan.admin');
            Route::post('tolak', [App\Http\Controllers\Admin\PencairanBonusController::class, 'reject'])->name('reject.pencairan.admin');
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

