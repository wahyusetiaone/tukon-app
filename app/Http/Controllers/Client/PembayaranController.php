<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\PembayaranResourceController;
use App\Models\Clients;
use App\Models\Pembayaran;
use App\Models\Transaksi_Pembayaran;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;
use function PHPUnit\Framework\never;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $data = Pembayaran::with('pin', 'pin.pengajuan', 'pin.tukang', 'pin.tukang.user', 'transaksi_pembayaran', 'project')->whereHas('pin.pengajuan', function ($query) {
            $query->where('kode_client', Auth::id());
        })->paginate(5)->toArray();
        return view('client.pembayaran.all')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function create(int $id, Request $request)
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
        try {
            $data = Pembayaran::with('pin', 'pin.pengajuan', 'pin.tukang', 'pin.tukang.user', 'transaksi_pembayaran', 'project')->whereHas('pin.pengajuan', function ($query) {
                $query->where('kode_client', Auth::id());
            })->where(['id' => $id])->firstOrFail();

            $data_user = Clients::with('user')->find(Auth::id());

            return view('client.pembayaran.show')->with(compact('data', 'data_user'));
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
     * Show Offline the form for creating a new resource.
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function createOffline(int $id, Request $request)
    {
        return view('client.pembayaran.payoffline')->with(compact('id'));
    }

    /**
     * Store Offline a newly created resource in storage.
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function storeOffline(Request $request, int $id)
    {
        $kode_user = User::with('client')->find(Auth::id())->kode_user;

        $validasi = Pembayaran::with('pin', 'pin.pengajuan')->find($id);

        if ($kode_user == $validasi->pin->pengajuan->kode_client) {
            if ($validasi->kode_status == "P01" || $validasi->kode_status == "P01A") {
                if ($request->hasfile('path_transaksi')) {
                    $file = $request->file('path_transaksi');
                    $path = null;
                    if ($file->isValid()) {
                        $path = $file->store('images/pembayaran', 'public');
                        $path = substr($path, 6);
                        $path = "storage/images" . $path;
                    }

                    if (!$request->has('note_transaksi')) {
                        $request['note_transaksi'] = "---";
                    }

                    $data = new Transaksi_Pembayaran();
                    $data->kode_pembayaran = $id;
                    $data->note_transaksi = $request['note_transaksi'];
                    $data->status_transaksi = "A01";
                    $data->path = $path;
                    $data->save();
                    Alert::success('Status Pembayaran', 'Bukti pembayaran berhasil di upload, mohon tunggu admin melakukan konfirmasi. Maximal 2 x 24 jam, hari libur tidak termasuk.');
                    return redirect()->route('show.pembayaran.client', $id);
                }
                Alert::error('Error Pembayaran Menunggu', 'File yang anda upload bermasalah !!!');
                return redirect()->route('show.pembayaran.client', $id);
            }
            Alert::warning('Status Pembayaran Menunggu', 'Mohon tunggu untuk admin melakukan verifikasi transaksi anda sebelumnya !!!');
            return redirect()->route('show.pembayaran.client', $id);
        }

        Alert::error('Error Status Pembayaran', 'Tidak ada akses untuk merubah data ini !!!');
        return redirect()->route('show.pembayaran.client', $id);
    }
}
