<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BPA;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class BPAController extends Controller
{
    public function json()
    {
        $data = BPA::withTrashed()->latest('created_at')->get();

        return Datatables::of($data)->addIndexColumn()
            ->addColumn('status', function ($data) {
                if ($data->deleted_at != null) {
                    $button = '<span class="badge badge-secondary">unactive</span>';
                } else {
                    $button = '<span class="badge badge-info">activee</span>';
                }
                return $button;
            })
            ->addColumn('dibuat', function ($data) {
                return indonesiaDate($data->created_at);
            })
            ->addColumn('dinonactive', function ($data) {
                if ($data->deleted_at == null){
                    return '-';
                }
                return indonesiaDate($data->deleted_at);
            })
            ->rawColumns(['status'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.bpa.all');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {

        $bpaold = BPA::first();
        $bpaold->delete();

        $bpanew = new BPA();
        $bpanew->bpa = $request->input('bpa');
        $bpanew->save();

        Alert::success('Biaya Penggunaan Aplikasi', 'Berhasil dirubah !!!');
        return redirect()->back();
    }

}
