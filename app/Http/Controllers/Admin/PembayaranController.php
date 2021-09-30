<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminPembayaranResourceController;
use App\Models\Pembayaran;
use App\Models\Transaksi_Pembayaran;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class PembayaranController extends Controller
{

    public function json()
    {
        $data = Pembayaran::with('pin.pengajuan.client.user')->where('kode_status', 'P01B')->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($data) {
                $button = '<a href="' . url('su/pembayaran/show/'. $data->id ). '"><button type="button" name="show" id="' . $data->id . '" class="edit btn btn-warning btn-sm">Konfirmasi</button></a>';
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
        return view('admin.pembayaran.all');
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
        $data = Pembayaran::with('pin.pengajuan.client.user','transaksi_pembayaran')->find($id);

        return view('admin.pembayaran.show')->with(compact('data'));
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
     * Show the form for accpet a payment.
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function accept(Request $request, int $id)
    {
        $this->validate($request, [
            'id_transaksi' => 'required|integer',
            'note_return_transaksi' => 'required|string',
        ]);

        try {
            Pembayaran::with('transaksi_pembayaran')->where('id',$id)->firstOrFail();
            $data = Transaksi_Pembayaran::find($request->id_transaksi);
            $data->status_transaksi = "A03";
            $data->note_return_transaksi = $request->note_return_transaksi;
            $data->save();

            Alert::success('Status Pembayaran', 'Berhasil diterima !!!');
            return redirect()->route('pembayaran.admin');
        }catch (ModelNotFoundException $ee){
            Alert::error('Ops...', 'Sesuatu tidak berfungsi semestinya !!!');
            return redirect()->back();
        }
    }

    /**
     * Show the form for reject a payment.
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function reject(Request $request, int $id)
    {
        $this->validate($request, [
            'id_transaksi' => 'required|integer',
            'note_return_transaksi' => 'required|string',
        ]);

        try {
            Pembayaran::with('transaksi_pembayaran')->where('id',$id)->firstOrFail();
            $data = Transaksi_Pembayaran::find($request->id_transaksi);
            $data->status_transaksi = "A02";
            $data->note_return_transaksi = $request->note_return_transaksi;
            $data->save();

            Alert::success('Status Pembayaran', 'Berhasil ditolak !!!');
            return redirect()->route('pembayaran.admin');
        }catch (ModelNotFoundException $ee){
            Alert::error('Ops...', 'Sesuatu tidak berfungsi semestinya !!!');
            return redirect()->back();
        }
    }
}
