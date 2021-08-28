<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penawaran;
use App\Models\Pin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class PenawaranController extends Controller
{
    public function json()
    {
        $param = [
            'query'
        ];
        if ($this->fun_Check($param)) {
            $query = $this->fun_Query($param);
            $data = Penawaran::with('pin.pengajuan.client.user','pin.tukang.user')
                ->where('id', '=', $query['query'])
                ->orWhereHas('pin.tukang.user', function ($q) use ($query){
                    $q->where('name', 'like', '%'.$query['query'].'%');
                })
                ->get();
        } else {
            $data = [];
        }

        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($data) {
                if (isset($data->pengajuan->deleted_at)) {
                    $button = '<a href="' . url('admin/penawaran/show') . '/' . $data->pin->id . '"><button type="button" name="show" id="' . $data->id . '" class="edit btn btn-danger btn-sm" disabled>Deleted</button></a>';
                } else {
                    $button = '<a href="' . url('admin/penawaran/show') . '/' . $data->pin->id . '"><button type="button" name="show" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Show</button></a>';
                }
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
        return view('admin.penawaran.all');
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
            $data = Pin::with('revisi','pengajuan','pengajuan.client','pengajuan.client.user','tukang.user','penawaran.komponen','pembayaran')->where(['id' => $id])->firstOrFail();

            return view('admin.penawaran.show')->with(compact('data'));
        }catch (ModelNotFoundException $ee){
            return View('errors.404');
        }
    }

    private function fun_Check(array $param)
    {
        $has = false;
        foreach ($param as $item){
            $has = $has || request()->has($item);
            if (request()->input($item) == null ){
                $has = false;
            }
        }
        return $has;
    }

    private function fun_Query(array $param)
    {
        $has = array();
        foreach ($param as $item){
            if (request()->has($item)){
                $has[$item] = request()->input($item);
            }else{
                $has[$item] = "";
            }
        }
        return $has;
    }
}
