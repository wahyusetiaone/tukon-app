<?php

namespace App\Http\Controllers\Tukang;

use App\Http\Controllers\Controller;
use App\Http\Resources\PenarikanDanaResourceController;
use App\Models\PenarikanDana;
use App\Models\Persentase_Penarikan;
use App\Models\Transaksi_Penarikan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class PenarikanDanaController extends Controller
{
    public function json()
    {
        $user = Auth::id();
        $data = PenarikanDana::with(['project.pembayaran.pin.pengajuan' => function ($query) {
            $query->select('id', 'nama_proyek');
        }])->whereHas('project.pembayaran.pin', function ($query) use ($user) {
            $query->where('kode_tukang', '=', $user);
        })->whereHas('project', function ($query) {
            $query->where('kode_status', '!=', 'ON03');
        })->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('status', function ($data) {
                $button = '<span class="badge bg-info">Aktif</span>';
                if ($data->project->kode_status == "ON05") {
                    $button = '<span class="badge bg-success">Selesai</span>';
                }
                return $button;
            })
            ->addColumn('action', function ($data) {
                $button = '<a href="' . url('penarikan-dana/show') . '/' . $data->id . '"><button type="button" name="manage" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Manage</button></a>';
                return $button;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('tukang.penarikan_dana.all');
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
     * @param int $id
     * @param int $persen
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, int $id, int $persen)
    {
        $penarikan = PenarikanDana::with('project', 'limitasi_penarikan')->whereHas('project.pembayaran.pin', function ($query) {
            $query->where('kode_tukang', Auth::id());
        })->where('id', $id)->first();

        //6 adalah kode pembayaran 100%
        $avaliable = Persentase_Penarikan::all()->pluck('value')->toArray();
        if ($penarikan->kode_limitasi == 1) {
            unset($avaliable[5]);
        }
        if ($penarikan->persentase_penarikan == 100) {
            unset($avaliable[5]);
        }
        if ($penarikan->persentase_penarikan > 25) {
            unset($avaliable[4]);
        }
        if ($penarikan->persentase_penarikan > 30) {
            unset($avaliable[3]);
        }
        if ($penarikan->persentase_penarikan > 35) {
            unset($avaliable[2]);
        }
        if ($penarikan->persentase_penarikan > 40) {
            unset($avaliable[1]);
        }
        if ($penarikan->persentase_penarikan > 45) {
            unset($avaliable[0]);
        }
        if (!in_array($persen, $avaliable)) {
            Alert::error('Pengajuan Penarikan Gagal', 'Tidak dapat menarik dengan persentase '.$persen.'% !!!');
            return redirect(route('show.penarikan.dana',$id));
        }
        $user = User::find(Auth::id());
        $hasher = app('hash');

        $request->validate([
            'password' => 'required|password|min:8'
        ]);
        if ($hasher->check($request->input('password'), $user->password)) {

            DB::transaction(function () use ($penarikan, $persen){
                $pen = ($penarikan->total_dana * ($persen/100));
                $per = Persentase_Penarikan::where('value', $persen)->first();
                $transaksi = new Transaksi_Penarikan();
                $transaksi->kode_penarikan = $penarikan->id;
                $transaksi->kode_persentase_penarikan = $per->id;
                $transaksi->penarikan = $pen;
                $transaksi->kode_status = "PN01";
                $transaksi->save();
            });

            Alert::success('Pengajuan Penarikan Berhasil', 'Pengajuan dana telah di kirim ke klien untuk di konfirmasi !!!');
            return redirect(route('show.penarikan.dana',$id));
        }
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
        $data = PenarikanDana::with(['transaksi_penarikan.persentase','limitasi_penarikan','project.pembayaran.pin.pengajuan' => function ($query) {
            $query->select('id', 'nama_proyek');
        }])->whereHas('project.pembayaran.pin', function ($query) use ($user) {
            $query->where('kode_tukang', '=', $user);
        })->whereHas('project', function ($query) {
            $query->where('kode_status', '!=', 'ON03');
        })->where('id', $id)->first();

        if (!isset($data)){
            return View('errors.404');
        }

        $verifikasiBeforePenarikan = verificationBeforePenarikan(Auth::id(), $id);

        $penarikan = PenarikanDana::with('project', 'limitasi_penarikan')->whereHas('project.pembayaran.pin', function ($query) {
            $query->where('kode_tukang', Auth::id());
        })->where('id', $id)->first();

        //6 adalah kode pembayaran 100%
        $avaliable = Persentase_Penarikan::all()->except(6)->keyBy('value');

        if ($penarikan->kode_limitasi == 2) {
            if ($penarikan->persentase_penarikan != 100){
                $avaliable = Persentase_Penarikan::all()->keyBy('value');
            }
        }

        if ($penarikan->persentase_penarikan > 25) {
            $avaliable->forget(25);
        }
        if ($penarikan->persentase_penarikan > 30) {
            $avaliable->forget(20);
        }
        if ($penarikan->persentase_penarikan > 35) {
            $avaliable->forget(15);
        }
        if ($penarikan->persentase_penarikan > 40) {
            $avaliable->forget(10);
        }
        if ($penarikan->persentase_penarikan > 45) {
            $avaliable->forget(5);
        }

        return view('tukang.penarikan_dana.show')->with(compact('data','avaliable', 'verifikasiBeforePenarikan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $persen
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function konfirmasi(Request $request, int $id, int $persen)
    {
        $data = PenarikanDana::whereHas('project.pembayaran.pin', function ($query) {
            $query->where('kode_tukang', Auth::id());
        })->where('id', $id)->first();

        return view('tukang.penarikan_dana.konfirmasi')->with(compact('data', 'persen'));
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
}
