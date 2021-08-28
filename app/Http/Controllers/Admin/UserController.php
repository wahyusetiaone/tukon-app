<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\Tukang;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function jsonclient()
    {
        $param = [
            'query'
        ];
        if ($this->fun_Check($param)) {
            $query = $this->fun_Query($param);
            $data = Clients::with('user')
                ->whereHas('user', function ($q) use ($query){
                    $q->where('id', '=', $query['query'])
                        ->orWhere('name', 'like', '%'.$query['query'].'%')
                        ->orWhere('email', 'like', '%'.$query['query'].'%');
                })
                ->get();
        } else {
            $data = [];
        }

        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($data) {
                if (isset($data->pengajuan->deleted_at)) {
                    $button = '<a href="' . url('admin/user/klien/show') . '/' . $data->id . '"><button type="button" name="show" id="' . $data->id . '" class="edit btn btn-danger btn-sm" disabled>Deleted</button></a>';
                } else {
                    $button = '<a href="' . url('admin/user/klien/show') . '/' . $data->id . '"><button type="button" name="show" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Show</button></a>';
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
    public function indexclient()
    {
        return view('admin.user.all')->with(['title' => "Daftar Klient", 'placehold' => 'ID, Nama atau Email Klien']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function showclient($id)
    {
        try {
            $data = Clients::with('user')->where(['id' => $id])->firstOrFail();

            return view('admin.user.show')->with(compact('data'));
        }catch (ModelNotFoundException $ee){
            return View('errors.404');
        }
    }

    //tukang

    public function jsontukang()
    {
        $param = [
            'query'
        ];
        if ($this->fun_Check($param)) {
            $query = $this->fun_Query($param);
            $data = Tukang::with('user')
                ->whereHas('user', function ($q) use ($query){
                    $q->where('id', '=', $query['query'])
                        ->orWhere('name', 'like', '%'.$query['query'].'%')
                        ->orWhere('email', 'like', '%'.$query['query'].'%');
                })
                ->get();
        } else {
            $data = [];
        }

        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($data) {
                if (isset($data->pengajuan->deleted_at)) {
                    $button = '<a href="' . url('admin/user/tukang/show') . '/' . $data->id . '"><button type="button" name="show" id="' . $data->id . '" class="edit btn btn-danger btn-sm" disabled>Deleted</button></a>';
                } else {
                    $button = '<a href="' . url('admin/user/tukang/show') . '/' . $data->id . '"><button type="button" name="show" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Show</button></a>';
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
    public function indextukang()
    {
        return view('admin.user.all')->with(['title' => "Daftar Tukang", 'placehold' => 'ID, Nama atau Email Tukang']);;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function showtukang($id)
    {
        try {
            $data = Tukang::with('user.ban')->where(['id' => $id])->firstOrFail();

            return view('admin.user.show')->with(compact('data'));
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
