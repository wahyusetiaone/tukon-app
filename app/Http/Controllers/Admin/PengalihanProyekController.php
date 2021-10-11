<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ban;
use App\Models\Pin;
use App\Models\Project;
use App\Models\Tukang;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PengalihanProyekController extends Controller
{
    public function show(int $id)
    {
        try {
            $data = Tukang::with('user.ban')->where(['id' => $id])->firstOrFail();
            $proyek = Project::with('pembayaran.pin.pengajuan')
                ->whereHas('pembayaran.pin', function ($q) use ($id) {
                    $q->where('kode_tukang', 'like', $id);
                })->where('kode_status', 'ON01')->get();

            return view('admin.pengalihan_proyek.show')->with(compact('data', 'proyek'));
        } catch (ModelNotFoundException $ee) {
            return View('errors.404');
        }
    }

    public function cariPenyediajasa(string $query)
    {
        $data = Tukang::with('user')->whereHas('user', function ($q) use ($query) {
            $q->where('name', 'like', '%' . $query . '%');
        })->get();
        return response()->json($data)->setStatusCode(200);
    }

    public function storePengalihanProyek(Request $request, int $id)
    {
        $this->validate($request, [
            'reason' => 'required|string',
            'id_pin' => 'required|array',
            'id_penyedia_jasa' => 'required|array',
        ]);
        DB::transaction(function () use ($request, $id) {
            foreach ($request->input('id_pin') as $key => $value) {
                $tukang_id = $request->input('id_penyedia_jasa');
                $pin = Pin::whereId($value)->first();
                $pin->kode_tukang = $tukang_id[$key];
                $pin->save();
            }
            $ban = new Ban();
            $ban->user_id = $id;
            $ban->reason = $request->input('reason');
            $ban->save();
        });

        Alert::success('Succesfuly', 'Berhasil melakukan Banned Account !!!');
        return redirect()->route('show.pengguna.tukang.admin', $id);
    }
}
