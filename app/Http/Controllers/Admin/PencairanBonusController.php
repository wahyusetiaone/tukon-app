<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BonusAdminCabang;
use App\Models\Transaksi_Pencairan_Bonus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class PencairanBonusController extends Controller
{
    public function json()
    {
        $data = Transaksi_Pencairan_Bonus::with('bonus.project.pembayaran.pin.pengajuan', 'bonus.admin.user')->where('kode_status', '=', 'TB01')->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($data) {
                $button = '<a href="' . url('su/pencairan-bonus/show/' . $data->id) . '"><button type="button" name="show" id="' . $data->id . '" class="edit btn btn-warning btn-sm">Konfirmasi</button></a>';
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
        return view('admin.pencairan_bonus.all');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Transaksi_Pencairan_Bonus::with('bonus.project.pembayaran.pin.pengajuan', 'bonus.admin.user')->find($id);

        return view('admin.pencairan_bonus.show')->with(compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function acceptShow($id)
    {
        return view('admin.pencairan_bonus.terima')->with(compact('id'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function rejectShow($id)
    {
        return view('admin.pencairan_bonus.tolak')->with(compact('id'));
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
                return redirect()->route('pencairan.admin');
            }
            $path = $request->file('bukti_tf_admin')->store('images/bukti_pencairan_bonus', 'public');
            $path = substr($path, 6);
            $path = "storage/images" . $path;
            $transaksi = Transaksi_Pencairan_Bonus::find($request->input('id_transaksi'));
            $transaksi->bukti_tf_admin = $path;
            $transaksi->kode_status = "TB03";
            $transaksi->save();

            Alert::success('Succesfully Saved', 'Berhasil melakukan konfirmasi pencairan bonus !!!');
            return redirect()->route('pencairan.admin');
        } catch (ModelNotFoundException $ee) {
            Alert::error('Error', 'Gagal melakukan perubahan data !!!');
            return redirect()->route('pencairan.admin');
        }
    }

    public function reject(Request $request)
    {
        $this->validate($request, [
            'id_transaksi' => 'required|integer',
            'catatan_penolakan' => 'required|string',
        ]);

        try {
            $transaksi = Transaksi_Pencairan_Bonus::find($request->input('id_transaksi'));
            $transaksi->catatan_penolakan = $request->input('catatan_penolakan');
            $transaksi->kode_status = "TB02";
            $transaksi->save();

            Alert::success('Succesfully Saved', 'Berhasil menolak pencairan bonus !!!');
            return redirect()->route('pencairan.admin');
        } catch (ModelNotFoundException $ee) {
            Alert::error('Error', 'Gagal melakukan perubahan data !!!');
            return redirect()->route('pencairan.admin');
        }
    }
}
