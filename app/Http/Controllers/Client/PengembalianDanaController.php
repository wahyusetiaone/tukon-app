<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\PengembalianDanaResourceController;
use App\Models\PengembalianDana;
use App\Models\Transaksi_Pengembalian;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PengembalianDanaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $data = PengembalianDana::with('project.pembayaran.pin.pengajuan')->whereHas('project.pembayaran.pin.pengajuan', function ($query) {
            $query->where('kode_client', Auth::id());
        })
            ->orderByDesc('created_at')
            ->paginate(10)->toArray();

        return view('client.pengembalian_dana.v2.all')->with(compact('data'));
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'id_pengembalian' => 'string|required',
            'nomor_rekening' => 'string|required',
            'atas_nama_rekening' => 'string|required',
            'bank' => 'string|required',
        ]);

        $id = $request->input('id_pengembalian');

        if (!PengembalianDana::find($id)->exists()) {

            Alert::error('Error', 'ID tidak ditemukan pada server !!!');
            return redirect()->back();
        }

        $validasi = PengembalianDana::with('project.pembayaran.pin.pengajuan')->find($id);

        if (Auth::id() == $validasi->project->pembayaran->pin->pengajuan->kode_client) {

            if ($validasi->kode_status == 'PM02') {

                Alert::error('Error', 'Transaksi pengajuan Pengembalian Dana sebelumnya belum di respon oleh admin, anda tidak dapat melakukan pengajuan kembali. Mohon untuk menunggu respon dari admin, terimakasih.');
                return redirect()->back();
            }
            if ($validasi->kode_status == 'PM03') {
                Alert::error('Error', 'Transaksi Pengembalian Dana telah berhasil. Anda tidak dapat mengajukan kembali.');
                return redirect()->back();
            }

            $tr = new Transaksi_Pengembalian();
            $tr->kode_pengembalian_dana = $validasi->id;
            $tr->nomor_rekening = $request->input('nomor_rekening');
            $tr->atas_nama_rekening = $request->input('atas_nama_rekening');
            $tr->bank = $request->input('bank');
            $tr->save();
            Alert::success('Successfuly', 'Transaksi Pengembalian Dana telah berhasil di ajukan, mohon menunggu konfirmasi pengembalian oleh admin selama 2x24jam tidak termasuk hari libur. Terimakasih.');
            return redirect()->back();
        }

        Alert::error('Error', 'Tidak ada akses untuk merubah data ini !!!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = PengembalianDana::with('project.pembayaran.pin.pengajuan.client.user', 'project.penarikan', 'transaksi', 'penalty')
                ->find($id);

            $data['hasTransaksi'] = (count($data->transaksi) != 0) ? true : false;

            return view('client.pengembalian_dana.v2.show')->with(compact('data'));
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
}
