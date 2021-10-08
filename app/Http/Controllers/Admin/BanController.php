<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\BanResourceController;
use App\Models\Ban;
use App\Models\BonusAdminCabang;
use App\Models\VerificationTukang;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class BanController extends Controller
{
    /**
     * Banned the specified resource.
     *
     * @param int $id
     * @param Request $request
     * @return BanResourceController|\Illuminate\Http\JsonResponse|object
     */
    public function banned(int $id, Request $request)
    {
        $this->validate($request, [
            'reason' => 'required|string'
        ]);

        try {
            $has = Ban::with('user')->whereHas('user', function ($q) use ($id) {
                $q->where('id', $id);
            })->exists();
            if ($has) {
                return (new BanResourceController(['status' => false, 'message' => 'Akun sudah terbanned !!!']))->response()->setStatusCode(401);
            }
            $ban = new Ban();
            $ban->user_id = $id;
            $ban->reason = $request->input('reason');
            $ban->save();
            Alert::success('Succesfuly', 'Berhasil melakukan Banned Account !!!');
            return redirect()->back();
        } catch (ModelNotFoundException $ee) {
            Alert::error('Error', 'Gagal melakukan Banned Account !!!');
            return redirect()->back();
        }
    }

    /**
     * Banned the specified resource.
     *
     * @param int $id
     * @return BanResourceController|\Illuminate\Http\JsonResponse|object
     */
    public function unbanned($id)
    {
        try {
            $has = Ban::with('user')->whereHas('user', function ($q) use ($id) {
                $q->where('id', $id);
            })->exists();
            if (!$has) {
                return (new BanResourceController(['status' => false, 'message' => 'Akun ini tidak sedang di banned !!!']))->response()->setStatusCode(401);
            }
            Ban::where('user_id', $id)->delete();
            return (new BanResourceController(['status' => true]))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $ee) {
            return (new BanResourceController(['status' => false, 'message' => $ee]))->response()->setStatusCode(401);
        }
    }

    //admincabang

    /**
     * Banned the specified resource.
     *
     * @param int $id
     * @param Request $request
     * @return BanResourceController|\Illuminate\Http\JsonResponse|object
     */
    public function bannedAdminCabang(int $id, Request $request)
    {
        $this->validate($request, [
            'reason' => 'required|string'
        ]);

        try {
            DB::transaction(function () use ($id,$request){

                $bonusActive = BonusAdminCabang::with('project')->whereHas('project', function ($q) {
                    $q->where('kode_status', 'ON01');
                })->where('kode_status', 'BA01')->where('admin_id', $id)->get();

                foreach ($bonusActive as $item) {
                    $item->update(['admin_id' => 0, 'dialihkan' => true]);
                }

                $has = Ban::with('user')->whereHas('user', function ($q) use ($id) {
                    $q->where('id', $id);
                })->exists();
                if ($has) {
                    return (new BanResourceController(['status' => false, 'message' => 'Akun sudah terbanned !!!']))->response()->setStatusCode(401);
                }
                $ban = new Ban();
                $ban->user_id = $id;
                $ban->reason = $request->input('reason');
                $ban->save();

                //alokasi bonus pindah ke pusat
                $v = VerificationTukang::where('admin_id', $id);
                $v->update(['alokasi_bonus_id' => 0]);

            });
            Alert::success('Succesfuly', 'Berhasil melakukan Banned Account !!!');
            return redirect()->back();
        } catch (ModelNotFoundException $ee) {
            Alert::error('Error', 'Gagal melakukan Banned Account !!!');
            return redirect()->back();
        }
    }

    /**
     * Banned the specified resource.
     *
     * @param int $id
     * @return BanResourceController|\Illuminate\Http\JsonResponse|object
     */
    public function unbannedAdminCabang($id)
    {
        try {
            $has = Ban::with('user')->whereHas('user', function ($q) use ($id) {
                $q->where('id', $id);
            })->exists();
            if (!$has) {
                return (new BanResourceController(['status' => false, 'message' => 'Akun ini tidak sedang di banned !!!']))->response()->setStatusCode(401);
            }
            Ban::where('user_id', $id)->delete();

            //alokasi bonus dikembalikan
            $v = VerificationTukang::where('admin_id', $id);
            $v->update(['alokasi_bonus_id' => $id]);

            return (new BanResourceController(['status' => true]))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $ee) {
            return (new BanResourceController(['status' => false, 'message' => $ee]))->response()->setStatusCode(401);
        }
    }
}
