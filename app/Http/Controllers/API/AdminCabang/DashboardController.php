<?php

namespace App\Http\Controllers\API\AdminCabang;

use App\Http\Controllers\Controller;
use App\Http\Resources\DashboardResourceController;
use App\Models\Admin;
use App\Models\BonusAdminCabang;
use App\Models\Tukang;
use App\Models\VerificationTukang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function index(Request $request)
    {

        $dashbord['cabang'] = Admin::with('has_cabang.cabang')->whereId(Auth::id())->first();
        $dashbord['verification_success'] = VerificationTukang::where('admin_id', Auth::id())->where('status', 'V02')->count();
        $dashbord['verification_pandding'] = VerificationTukang::where('admin_id', Auth::id())->where('status', 'V01')->count();
        $dashbord['verification_gagal'] = VerificationTukang::where('admin_id', Auth::id())->where('status', 'V03')->count();
        $dashbord['bonus'] = BonusAdminCabang::with('project.pembayaran.pin.pengajuan')->where('admin_id',Auth::id())->latest()->limit(5)->get();

        return (new DashboardResourceController(['data' => $dashbord]))->response()->setStatusCode(200);
    }
}
