<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PenarikanDanaResourceController;
use App\Models\Pembayaran;
use App\Models\PenarikanDana;
use App\Models\Transaksi_Penarikan;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class PenarikanDanaController extends Controller
{
    public function json()
    {
        $data = Transaksi_Penarikan::with(['penarikan_dana.project.pembayaran.pin.tukang.user', 'penarikan_dana.project.pembayaran.pin.pengajuan' => function ($query) {
            $query->select('id', 'nama_proyek');
        }])->whereHas('penarikan_dana.project', function ($query) {
            $query->where('kode_status', '!=', 'ON03');
        })->where('kode_status', '=', 'PN03')->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($data) {
                $button = '<a href="' . url('su/penarikan-dana/show/' . $data->id) . '"><button type="button" name="show" id="' . $data->id . '" class="edit btn btn-warning btn-sm">Konfirmasi</button></a>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.penarikan_dana.all');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Transaksi_Penarikan::with('penarikan_dana.project.pembayaran.pin.tukang.user', 'penarikan_dana.project.pembayaran.pin.pengajuan')->find($id);

        return view('admin.penarikan_dana.show')->with(compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function acceptShow($id)
    {
        return view('admin.penarikan_dana.terima')->with(compact('id'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function rejectShow($id)
    {
        return view('admin.penarikan_dana.tolak')->with(compact('id'));
    }

    /**
     * Show the form for accpet a payment.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function accept(Request $request)
    {
        $this->validate($request, [
            'id_transaksi' => 'required|integer',
            'bukti_tf_admin' => 'required|mimes:jpg,jpeg,png|max:1000',
        ]);

        try {
            if (!$request->file('bukti_tf_admin')->isValid()) {
                Alert::error('Error', 'Foto yang anda masukan tidak valid !!!');
                return redirect()->route('penarikan.admin');
            }
            $path = $request->file('bukti_tf_admin')->store('images/bukti_penarikan', 'public');
            $path = substr($path, 6);
            $path = "storage/images" . $path;
            $transaksi = Transaksi_Penarikan::find($request->input('id_transaksi'));
            $transaksi->bukti_tf_admin = $path;
            $transaksi->kode_status = "PN05";
            $transaksi->save();

            Alert::success('Succesfully Saved', 'Berhasil melakukan konfirmasi penarikan !!!');
            return redirect()->route('penarikan.admin');
        } catch (ModelNotFoundException $ee) {
            Alert::error('Error', 'Gagal melakukan perubahan data !!!');
            return redirect()->route('penarikan.admin');
        }
    }

    public function reject(Request $request)
    {
        $this->validate($request, [
            'id_transaksi' => 'required|integer',
            'catatan_penolakan' => 'required|string',
        ]);

        try {
            $transaksi = Transaksi_Penarikan::find($request->input('id_transaksi'));
            $transaksi->catatan_penolakan = $request->input('catatan_penolakan');
            $transaksi->kode_status = "PN04";
            $transaksi->save();

            Alert::success('Succesfully Saved', 'Berhasil menolak penarikan !!!');
            return redirect()->route('penarikan.admin');
        } catch (ModelNotFoundException $ee) {
            Alert::error('Error', 'Gagal melakukan perubahan data !!!');
            return redirect()->route('penarikan.admin');
        }
    }
}
