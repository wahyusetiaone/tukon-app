<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengembalianDana;
use App\Models\Transaksi_Pengembalian;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class PengembalianDanaController extends Controller
{
    public function json()
    {
        $data = PengembalianDana::with('project.pembayaran.pin.pengajuan.client.user')->where('kode_status', 'PM02')->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($data) {
                $button = '<a href="' . url('admin/pengembalian-dana/show/' . $data->id) . '"><button type="button" name="show" id="' . $data->id . '" class="edit btn btn-warning btn-sm">Konfirmasi</button></a>';
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
        return view('admin.pengembalian_dana.all');
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
        $data = PengembalianDana::with('project.pembayaran.pin.pengajuan.client.user','project.penarikan', 'transaksi','penalty')
            ->whereHas('transaksi', function ($q){
                $q->where('kode_status', 'TP01')->take(1);;
            })
            ->find($id);

        return view('admin.pengembalian_dana.show')->with(compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function acceptShow($id)
    {
        return view('admin.pengembalian_dana.terima')->with(compact('id'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function rejectShow($id)
    {
        return view('admin.pengembalian_dana.tolak')->with(compact('id'));
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
                return redirect()->route('pengembalian-dana.admin');
            }
            $path = $request->file('bukti_tf_admin')->store('images/bukti_pengembalian', 'public');
            $path = substr($path, 6);
            $path = "storage/images" . $path;
            $transaksi = Transaksi_Pengembalian::find($request->input('id_transaksi'));
            $transaksi->path_bukti = $path;
            $transaksi->kode_status = "TP03";
            $transaksi->save();

            Alert::success('Succesfully Saved', 'Berhasil melakukan konfirmasi pengembalian dana !!!');
            return redirect()->route('pengembalian-dana.admin');
        } catch (ModelNotFoundException $ee) {
            Alert::error('Error', 'Gagal melakukan perubahan data !!!');
            return redirect()->route('pengembalian-dana.admin');
        }
    }

    public function reject(Request $request)
    {
        $this->validate($request, [
            'id_transaksi' => 'required|integer',
            'catatan_penolakan' => 'required|string',
        ]);

        try {
            $transaksi = Transaksi_Pengembalian::find($request->input('id_transaksi'));
            $transaksi->catatan_penolakan = $request->input('catatan_penolakan');
            $transaksi->kode_status = "TP02";
            $transaksi->save();

            Alert::success('Succesfully Saved', 'Berhasil menolak pengembalian dana !!!');
            return redirect()->route('pengembalian-dana.admin');
        } catch (ModelNotFoundException $ee) {
            Alert::error('Error', 'Gagal melakukan perubahan data !!!');
            return redirect()->route('pengembalian-dana.admin');
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
}
