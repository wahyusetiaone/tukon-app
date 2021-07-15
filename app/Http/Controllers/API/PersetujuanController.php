<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PersetujuanResourceController;
use App\Models\Penawaran;
use App\Models\Pengajuan;
use App\Models\Pin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersetujuanController extends Controller
{
    /**
     * Show the form for updating a new resource from client.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function accept_client(Request $request, int $id)
    {
        $kode_user = User::with('client')->find(Auth::id())->kode_user;
        $penawaran = Penawaran::with('pin', 'pin.pengajuan')->where('id',$id)->first();

        if ($kode_user == $penawaran->pin->pengajuan->kode_client){

            if (!is_null($penawaran->pin->kode_penawaran)){

                $data = Pin::find($penawaran->pin->id);
                $data->update(['status' => 'D01A']);
                return (new PersetujuanResourceController(['update_status' => $data]))->response()->setStatusCode(200);
            }else{
                return (new PersetujuanResourceController(['error' => "Tidak bisa melakukan persetujuan projek karena tukang belum melakukan penawaran!!"]))->response()->setStatusCode(401);
            }
        }else{

            return (new PersetujuanResourceController(['error' => 'Mohon maaf, anda tidak mendapat akses untuk mengubah record ini !!!']))->response()->setStatusCode(401);
        }
    }

    /**
     * Show the form for updating a new resource from client.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function accept_tukang(Request $request, int $id)
    {
        $kode_user = User::with('client')->find(Auth::id())->kode_user;
        $penawaran = Penawaran::with('pin', 'pin.pengajuan')->where('id',$id)->first();

        if ($kode_user == $penawaran->pin->kode_tukang){

            if ($penawaran->pin->status == "D01A"){

                $data = Pin::find($penawaran->pin->id);
                $data->update(['status' => 'D02']);
                return (new PersetujuanResourceController(['update_status' => $data]))->response()->setStatusCode(200);
            }else{
                return (new PersetujuanResourceController(['error' => "Tidak bisa melakukan persetujuan projek karena klien belum melakukan persetujuan tehadap penawaran anda!!"]))->response()->setStatusCode(401);
            }
        }else{

            return (new PersetujuanResourceController(['error' => 'Mohon maaf, anda tidak mendapat akses untuk mengubah record ini !!!']))->response()->setStatusCode(401);
        }
    }
}
