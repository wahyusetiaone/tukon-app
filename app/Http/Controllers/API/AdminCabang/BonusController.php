<?php

namespace App\Http\Controllers\API\AdminCabang;

use App\Http\Controllers\Controller;
use App\Http\Resources\BonusResourceController;
use App\Models\BonusAdminCabang;
use App\Models\Transaksi_Pencairan_Bonus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BonusController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function index(Request $request)
    {

        $data = BonusAdminCabang::ambilBonus($request->input('only'), Auth::id());

        return (new BonusResourceController(['data' => $data]))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function ajukan(int $id)
    {

        if (!BonusAdminCabang::whereId($id)->exists()){
            return (new BonusResourceController(['error' => 'Data tidak ditemukan']))->response()->setStatusCode(404);
        }

        $data = BonusAdminCabang::with('project')->whereId($id)->first();

        if (BonusAdminCabang::where('admin_id', Auth::id())->where('kode_status', 'BA02')->exists()){
            return (new BonusResourceController(['error' => 'Gagal mengajukan pencairan dana, masih ada proses pengajuan pencairan dana yang masih padding, mohon menunggu hingga proses transaksi tersebut selesai !']))->response()->setStatusCode(403);
        }

        if ($data->project->kode_status == 'ON05'){
            if ($data->kode_status == 'BA01'){
                $tr = new Transaksi_Pencairan_Bonus();
                $tr->bonus_admin_id = $data->id;
                $tr->pencairan = $data->bonus;
                $tr->save();
            }else{
                return (new BonusResourceController(['error' => 'Gagal mengajukan pencairan dana !']))->response()->setStatusCode(403);
            }
        }else{
            return (new BonusResourceController(['error' => 'Gagal mengajukan pencairan dana, karena status proyek belum selesai !']))->response()->setStatusCode(403);
        }

        return (new BonusResourceController(['data' => 'Berhasil di ajukan']))->response()->setStatusCode(200);
    }

}
