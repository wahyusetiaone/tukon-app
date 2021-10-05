<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\RegisterAdminCabangMail;
use App\Models\Admin;
use App\Models\Clients;
use App\Models\PreRegistrationAdmin;
use App\Models\Tukang;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
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
                ->whereHas('user', function ($q) use ($query) {
                    $q->where('id', '=', $query['query'])
                        ->orWhere('name', 'like', '%' . $query['query'] . '%')
                        ->orWhere('email', 'like', '%' . $query['query'] . '%');
                })
                ->get();
        } else {
            $data = [];
        }

        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($data) {
                if (isset($data->pengajuan->deleted_at)) {
                    $button = '<a href="' . url('su/user/klien/show') . '/' . $data->id . '"><button type="button" name="show" id="' . $data->id . '" class="edit btn btn-danger btn-sm" disabled>Deleted</button></a>';
                } else {
                    $button = '<a href="' . url('su/user/klien/show') . '/' . $data->id . '"><button type="button" name="show" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Show</button></a>';
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
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function showclient($id)
    {
        try {
            $data = Clients::with('user')->where(['id' => $id])->firstOrFail();

            return view('admin.user.show')->with(compact('data'));
        } catch (ModelNotFoundException $ee) {
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
                ->whereHas('user', function ($q) use ($query) {
                    $q->where('id', '=', $query['query'])
                        ->orWhere('name', 'like', '%' . $query['query'] . '%')
                        ->orWhere('email', 'like', '%' . $query['query'] . '%');
                })
                ->get();
        } else {
            $data = [];
        }

        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($data) {
                if (isset($data->pengajuan->deleted_at)) {
                    $button = '<a href="' . url('su/user/tukang/show') . '/' . $data->id . '"><button type="button" name="show" id="' . $data->id . '" class="edit btn btn-danger btn-sm" disabled>Deleted</button></a>';
                } else {
                    $button = '<a href="' . url('su/user/tukang/show') . '/' . $data->id . '"><button type="button" name="show" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Show</button></a>';
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
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function showtukang($id)
    {
        try {
            $data = Tukang::with('user.ban')->where(['id' => $id])->firstOrFail();

            return view('admin.user.show')->with(compact('data'));
        } catch (ModelNotFoundException $ee) {
            return View('errors.404');
        }
    }

    private function fun_Check(array $param)
    {
        $has = false;
        foreach ($param as $item) {
            $has = $has || request()->has($item);
            if (request()->input($item) == null) {
                $has = false;
            }
        }
        return $has;
    }

    private function fun_Query(array $param)
    {
        $has = array();
        foreach ($param as $item) {
            if (request()->has($item)) {
                $has[$item] = request()->input($item);
            } else {
                $has[$item] = "";
            }
        }
        return $has;
    }

    //admin

    public function jsonadmin()
    {
        $param = [
            'query'
        ];
        if ($this->fun_Check($param)) {
            $query = $this->fun_Query($param);
            $data = PreRegistrationAdmin::with('admin.user')
                ->whereHas('admin.user.ban', function ($q) use ($query) {
                    $q->where('id', '=', $query['query'])
                        ->orWhere('name', 'like', '%' . $query['query'] . '%');
                })
                ->orWhere('email', '=', $query['query'])
                ->get();
        } else {
            $data = PreRegistrationAdmin::with('user.admin', 'user.ban')->get();
        }

        return Datatables::of($data)->addIndexColumn()
            ->addColumn('status', function ($data) {
                if (isset($data->user->ban)) {
                    $sm = '<span class="badge badge-danger">Diblokir</span>';
                } else {
                    if (!$data->access) {
                        $sm = '<span class="badge badge-light">Belum diakses</span>';
                    } else {
                        $sm = '<span class="badge badge-success">Aktif</span>';
                    }
                }
                return $sm;
            })->addColumn('link', function ($data) {
                if (!$data->access) {
                    $sm = '<span class="badge badge-light">Belum diakses</span>';
                } else {
                    $sm = '<span class="badge badge-info">Telah diakses</span>';
                }
                return $sm;
            })->addColumn('action', function ($data) {
                if (isset($data->pengajuan->deleted_at)) {
                    $button = '<a href="' . url('su/user/admin-cabang/show') . '/' . $data->id . '"><button type="button" name="show" id="' . $data->id . '" class="edit btn btn-danger btn-sm" disabled>Deleted</button></a>';
                } else {
                    $button = '<a href="' . url('su/user/admin-cabang/show') . '/' . $data->id . '"><button type="button" name="show" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Show</button></a>';
                }
                return $button;
            })
            ->rawColumns(['link', 'status', 'action'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function indexadmin()
    {
        return view('admin.user.all')->with(['title' => "Daftar Admin Cabang", 'placehold' => 'ID, Nama atau Email Admin Cabang']);;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function showadmin($id)
    {
        try {
            $data = PreRegistrationAdmin::with('user.ban', 'user.admin')->where(['id' => $id])->firstOrFail();

            return view('admin.user.admin.show')->with(compact('data'));
        } catch (ModelNotFoundException $ee) {
            return View('errors.404');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function addadmin()
    {
        $prov = callMomWithGet(env('API_PROVINSI'));
        return view('admin.user.admin.add')->with(['title' => "Daftar Admin Cabang", 'placehold' => 'ID, Nama atau Email Admin Cabang', 'prov' => $prov]);;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeadmin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|unique:users,email|unique:pre_registration_admins,email',
            'duallistbox' => 'required'
        ]);
        $hash = md5($request->email);

        DB::transaction(function () use ($request, $hash, &$pre) {
            $pre = new PreRegistrationAdmin();
            $pre->hash = $hash;
            $pre->email = $request->input('email');
            $pre->cabang = json_encode($request->input('duallistbox'));
            $pre->save();
        });

        //send mail register
        Mail::to($request->input('email'))->send(new RegisterAdminCabangMail($pre));

        Alert::success('Succesfully Saved', 'Admin Cabang berhasil ditambah !');
        return redirect()->route('pengguna.admincabang.admin');
    }
}
