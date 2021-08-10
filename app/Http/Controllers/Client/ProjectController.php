<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResourceController;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $data = Project::with('pembayaran', 'pembayaran.pin','pembayaran.pin.pengajuan', 'pembayaran.pin.penawaran','pembayaran.pin.tukang','pembayaran.pin.tukang.user')->whereHas('pembayaran.pin.pengajuan', function ($query){
          $query->where('kode_client',Auth::id());
        })->paginate(5)->toArray();
        return view('client.project.all')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = Project::with('progress','progress.onprogress','progress.onprogress.doc','pembayaran','pembayaran.transaksi_pembayaran','pembayaran.pin','pembayaran.pin.pengajuan','pembayaran.pin.pengajuan.client','pembayaran.pin.pengajuan.client.user','pembayaran.pin.penawaran','pembayaran.pin.penawaran.komponen','pembayaran.pin.tukang','pembayaran.pin.tukang.user')->where('id', $id)->first();

            return view('client.project.show')->with(compact('data'));
        }catch (ModelNotFoundException $ee){
            return View('errors.404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function client_approve(int $id)
    {

        $validasi = Project::with('pembayaran', 'pembayaran.pin', 'pembayaran.pin.pengajuan')->find($id);

        if ($validasi->persentase_progress >= 90) {
            try {
                $data = Project::where('id',$id)->first();

                if ($data->kode_status == "ON02") {
                    Alert::error('Konfirmasi Selesai Proyek', 'Anda telah melakukan konfirmasi proyek, mohon menunggu tukang untuk mengkonfirmasinya !!!');
                    return redirect()->route('show.project.client', $id);
                }
                if ($data->kode_status == "ON01") {
                    Alert::error('Konfirmasi Selesai Proyek', 'Proyek belum dikonfirmasi selesai oleh tukang, mohon menunggu tukang untuk mengkonfirmasinya !!!');
                    return redirect()->route('show.project.client', $id);
                }
                if ($data->kode_status == "ON04") {
                    $data->update(['kode_status' => 'ON05']);
                    Alert::success('Konfirmasi Selesai Proyek', 'Status projek berhasil di update !!!');
                    return redirect()->route('show.project.client', $id);
                }
                if ($data->kode_status == "ON05") {
                    Alert::error('Konfirmasi Selesai Proyek', 'Status projek telah selesai, tidak dapat di ubah kembali !!!');
                    return redirect()->route('show.project.client', $id);
                }
                if ($data->kode_status == "ON03") {
                    Alert::error('Konfirmasi Selesai Proyek', 'Status projek telah dibatalkan, tidak dapat di ubah kembali !!!');
                    return redirect()->route('show.project.client', $id);
                }
            } catch (ModelNotFoundException $ee) {
                Alert::error('Konfirmasi Selesai Proyek', 'Proyek tidak ditemukan !!!');
                return redirect()->route('show.project.client', $id);
            }
        }
        Alert::error('Konfirmasi Selesai Proyek', 'Maaf status projek masih dalam tahap pengerjaan, anda tidak dapat melakukan tindakan ini !!!');
        return redirect()->route('show.project.client', $id);
    }
}
