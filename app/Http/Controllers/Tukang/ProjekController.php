<?php

namespace App\Http\Controllers\Tukang;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResourceController;
use App\Models\Pin;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class ProjekController extends Controller
{

    public function json()
    {
        $user = Auth::id();
        $data = Project::with('pembayaran.pin.pengajuan', 'pembayaran.pin.pembayaran')->whereHas('pembayaran.pin', function ($query) use ($user) {
            $query->where('kode_tukang', '=', $user);
        })->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($data) {
                $button = '<a href="' . url('projek/show') . '/' . $data->id . '"><button type="button" name="show" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Show</button></a>';
                return $button;
            })
            ->addColumn('status', function ($data) {
                $status = '<span class="badge bg-success">aktive</span>';
                if($data->kode_status == "ON02"){
                    $status = '<span class="badge bg-warning">menuggu konfirmasi</span>';
                }elseif($data->kode_status == "ON03"){
                    $status = '<span class="badge bg-danger">batal</span>';
                }elseif($data->kode_status == "ON04"){
                    $status = '<span class="badge bg-warning">menuggu konfirmasi</span>';
                }elseif($data->kode_status == "ON05"){
                    $status = '<span class="badge bg-info">selesai</span>';
                }
                return $status;
            })
            ->rawColumns(['action','status'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('tukang.project.all');
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::id();
        try {
            $data = Project::with('progress', 'progress.onprogress', 'progress.onprogress.doc', 'pembayaran', 'pembayaran.transaksi_pembayaran', 'pembayaran.pin', 'pembayaran.pin.pengajuan', 'pembayaran.pin.pengajuan.client', 'pembayaran.pin.pengajuan.client.user', 'pembayaran.pin.penawaran', 'pembayaran.pin.penawaran.komponen', 'pembayaran.pin.tukang', 'pembayaran.pin.tukang.user')->where('id', $id)->first();

            return view('tukang.project.show')->with(compact('data'));
        } catch (ModelNotFoundException $ee) {
            return View('errors.404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
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
    public function tukang_approve(int $id)
    {
        $validasi = Project::with('pembayaran', 'pembayaran.pin')->where('id',$id)->first();
        if ($validasi->persentase_progress == 100) {
            try {
                $data = Project::where('id',$id)->first();

                if ($data->kode_status == "ON04") {
                    Alert::error('Konfirmasi Selesai Proyek', 'Anda telah melakukan konfirmasi proyek, mohon menunggu klien untuk mengkonfirmasinya !!!');
                    return redirect()->route('show.projek', $id);
                }
                if ($data->kode_status == "ON01") {
                    $data->update(['kode_status' => 'ON04']);
                    Alert::success('Konfirmasi Selesai Proyek', 'Status projek berhasil di update !!!');
                    return redirect()->route('show.projek', $id);
                }
                if ($data->kode_status == "ON05") {
                    Alert::error('Konfirmasi Selesai Proyek', 'Status projek telah selesai, tidak dapat di ubah kembali !!!');
                    return redirect()->route('show.projek', $id);
                }
                if ($data->kode_status == "ON03") {
                    Alert::error('Konfirmasi Selesai Proyek', 'Status projek telah dibatalkan, tidak dapat di ubah kembali !!!');
                    return redirect()->route('show.projek', $id);
                }
            } catch (ModelNotFoundException $ee) {
                Alert::error('Konfirmasi Selesai Proyek', 'Proyek tidak ditemukan !!!');
                return redirect()->route('show.projek', $id);

            }
        }
        Alert::error('Konfirmasi Selesai Proyek', 'Maaf status projek masih dalam tahap pengerjaan, anda tidak dapat melakukan tindakan ini !!!');
        return redirect()->route('show.projek', $id);
    }
}
