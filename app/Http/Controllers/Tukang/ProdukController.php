<?php

namespace App\Http\Controllers\Tukang;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResourceController;
use App\Models\Produk;
use App\Models\Tukang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class ProdukController extends Controller
{
    public function json()
    {
        $tukang = Tukang::find(Auth::id());
        $data = $tukang->produk;
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $button = '<a href="' . url('produk/show?id=') . $data->id . '"><button type="button" name="show" id="' . $data->id . '" class="edit btn btn-primary-cs pr-4 pl-4 btn-sm">Show</button></a>';
                $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm pr-4 pl-4">Delete</button>';
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
        return view('tukang.produk.all');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('tukang.produk.add');
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_produk' => 'required'
        ]);

        $request->validate([
            'path.*' => 'mimes:jpg,jpeg,png|max:1000'
        ]);

        $id = User::with('tukang')->find(Auth::id())->kode_user;
        $request['kode_tukang'] = $id;
        $request->request->remove('_token');
        if ($request->hasfile('path_add')) {
            $files = [];
            $full_path = "";
            foreach ($request->file('path_add') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('images/produk', 'public');
                    $path = substr($path, 6);
                    $path = "storage/images" . $path;
                    if ($full_path == "") {
                        $full_path = $path;
                    } else {
                        $full_path = $full_path . "," . $path;
                    }
                    $files[] = [
                        'path' => $path,
                    ];
                }
            }
            $request['multipath'] = sizeof($files) > 1;
            $request['path'] = $full_path;
            Produk::create($request->all());
            Alert::success('Succesfully Saved', 'Data has been saved !!!');
            return redirect()->back();
        } else {
            Produk::create($request->all());
            Alert::success('Succesfully Saved', 'Data has been saved !!!');
            return redirect()->back();
        }
        Alert::error('Error Save', 'Data didn`t saved !!!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $data = Produk::find($request->id);

        return view('tukang.produk.show')->with(compact('data'));
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
     * //     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_produk' => 'required'
        ]);

        $request->validate([
            'path.*' => 'mimes:jpg,jpeg,png|max:1000'
        ]);

        $request->request->remove('_token');
        if ($request->hasfile('path_show')) {
            $files = [];
            $full_path = "";
            foreach ($request->file('path_show') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('images/produk', 'public');
                    $path = substr($path, 6);
                    $path = "storage/images" . $path;
                    if ($full_path == "") {
                        $full_path = $path;
                    } else {
                        $full_path = $full_path . "," . $path;
                    }
                    $files[] = [
                        'path' => $path,
                    ];
                }
            }
            $request['multipath'] = sizeof($files) > 1;
            $request['path'] = $full_path;
            Produk::whereId($id)->update($request->except('path_show'));
            Alert::success('Succesfully Update', 'Update data has been saved !!!');
            return redirect()->back();
        } else {
            Produk::whereId($id)->update($request->except('path_show'));
            Alert::success('Succesfully Updated', 'Update data has been saved !!!');
            return redirect()->back();
        }
        Alert::error('Error Update', 'Update data didn`t saved !!!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return bool
     */
    public function destroy($id)
    {
        Produk::where('id', $id)->delete();

        return true;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeImg(Request $request, $id)
    {
        $this->validate($request, [
            'urlImg' => 'required'
        ]);

        $spl = explode('/', $request->input('urlImg'));
        $namefile = $spl[(count($spl) - 1)];
        $path = $spl[(count($spl) - 4)].'/'.$spl[(count($spl) - 3)].'/'.$spl[(count($spl) - 2)].'/'.$spl[(count($spl) - 1)];
        $produk = Produk::select('multipath', 'path')->whereId($id)->first();
        $data = array();
        if ($produk->multipath) {
            $spl2 = explode(',', $produk->path);
            if (($key = array_search($path, $spl2)) !== false) {
                unset($spl2[$key]);
            }
            $data['multipath'] = count($spl2) > 1;
            $data['path'] = implode(",", $spl2);
            Produk::whereId($id)->update($data);
        } else {
            Produk::whereId($id)->update(['multipath' => false, 'path' => null]);
        }
        Storage::disk('public')->delete('images/produk' . $namefile);
        Alert::success('Succesfully Delete Photos', 'Update data has been saved !!!');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * //     * @return \Illuminate\Http\RedirectResponse
     */
    public function addImg(Request $request, $id)
    {
        $request->validate([
            'path.*' => 'mimes:jpg,jpeg,png|max:1000'
        ]);

        $request->request->remove('_token');
        if ($request->hasfile('path_show')) {
            $files = false;
            $produk = Produk::select('path')->whereId($id)->first();
            $full_path = $produk->path;
            foreach ($request->file('path_show') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('images/produk', 'public');
                    $path = substr($path, 6);
                    $path = "storage/images" . $path;
                    if ($full_path == "") {
                        $full_path = $path;
                    } else {
                        $full_path = $full_path . "," . $path;
                        $files = true;
                    }
                }
            }
            $request['multipath'] = $files;
            $request['path'] = $full_path;
            Produk::whereId($id)->update($request->except('path_show'));
            Alert::success('Succesfully Upload Image', 'Update data has been saved !!!');
            return redirect()->back();
        }
        Alert::error('Error Upload Image', 'Update data didn`t saved !!!');
        return redirect()->back();
    }
}
