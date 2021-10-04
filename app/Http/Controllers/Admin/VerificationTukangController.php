<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VerificationTukang;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class VerificationTukangController extends Controller
{
    public function json()
    {
        $data = VerificationTukang::with('tukang.user', 'admin.user')->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('status', function ($data) {
                if ($data->status == 'V01') {
                    $sm = '<span class="badge badge-warning">Menunggu</span>';
                } else if($data->status == 'V02') {
                    $sm = '<span class="badge badge-success">Terverifikasi</span>';
                }else if($data->status == 'V03') {
                    $sm = '<span class="badge badge-danger">Ditolak</span>';
                }
                return $sm;
            })
            ->addColumn('action', function ($data) {
                $button = '<a href="' . url('su/verification-tukang/show/' . $data->id) . '"><button type="button" name="show" id="' . $data->id . '" class="edit btn btn-primary-cs btn-sm">Lihat</button></a>';
                return $button;
            })
            ->rawColumns(['status','action'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.verification_tukang.all');
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
            $data = VerificationTukang::with('tukang.user', 'admin.user', 'berkas')->whereId($id)->first();

            return view('admin.verification_tukang.show')->with(compact('data'));
        }catch (ModelNotFoundException $ee){
            return View('errors.404');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function tolak(Request $request, int $id)
    {
        if (!VerificationTukang::whereId($id)->exists()){
            Alert::error('Verifikasi Error', 'ID Verifikasi tidak ditemukan !');
            return redirect()->back();
        }

        DB::transaction(function () use ($id, $request){
            $verification = VerificationTukang::whereId($id)->first();
            $verification->catatan = $request->input('catatan');
            $verification->status = 'V03';
            $verification->save();
        });

        Alert::success('Penolakan Verifikasi Berhasil', 'Verifikasi akun telah berhasil ditolak !');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifikasi(int $id)
    {
        if (!VerificationTukang::whereId($id)->exists()){
            Alert::error('Verifikasi Error', 'ID Verifikasi tidak ditemukan !');
            return redirect()->back();
        }

        DB::transaction(function () use ($id){
            $verification = VerificationTukang::whereId($id)->first();
            $verification->status = 'V02';
            $verification->save();
        });

        Alert::success('Verifikasi Berhasil', 'Verifikasi akun telah berhasil !');
        return redirect()->back();
    }
}
