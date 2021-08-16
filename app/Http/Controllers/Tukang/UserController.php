<?php

namespace App\Http\Controllers\Tukang;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResourceController;
use App\Models\Clients;
use App\Models\Produk;
use App\Models\Project;
use App\Models\Tukang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show()
    {
        if (!Tukang::where('id', Auth::id())->exists()) {
            return View('errors.404');
        }
        $client = Tukang::with('user')->where('id', Auth::id())->first();
        return view('tukang.profile.show')->with(compact('client'));
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if (!Tukang::where('id', Auth::id())->exists()) {
            Alert::error('Error Update Profile', 'User not found !');
            return redirect()->back();
        }
        $request->validate([
            'name' => 'required|string|max:50',
            'kota' => 'required|string|max:80',
            'alamat' => 'required|string',
            'nomor_telepon' => 'required|min:12',
            'email' => 'required|email',
        ]);
        Tukang::find($id)->update($request->except('name', 'email'));
        User::find($id)->update($request->only('name', 'email'));
        Alert::success('Succesfully Update Data Profile', 'Data has been saved !!!');
        return redirect()->back();
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
     * Display the specified resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function showNewPassword()
    {
        if (!Tukang::where('id', Auth::id())->exists()) {
            return View('errors.404');
        }
        $client = Tukang::with('user')->where('id', Auth::id())->first();
        return view('tukang.profile.newpassword')->with(compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateNewPassword(Request $request, $id)
    {
        if (!Tukang::where('id', Auth::id())->exists()) {
            Alert::error('Error Update Profile', 'User not found !');
            return redirect()->back();
        }

        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8|different:old_password',
            'c_new_password' => 'required|same:new_password'
        ]);

        $hasher = app('hash');
        $user = User::find(Auth::id());
        if (!$hasher->check($request->input('old_password'), $user->password)) {
            Alert::error('Error Reset Password', 'Password yang anda masukan salah !');
            return redirect()->back();
        }
        $new_password = $hasher->make($request->input('c_new_password'));
        User::find($id)->update(['password' => $new_password]);
        Alert::success('Succesfully Reset Password', 'Data has been saved !!!');
        return redirect()->route('show.user.ptofile');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function showChangePhoto()
    {
        if (!Tukang::where('id', Auth::id())->exists()) {
            return View('errors.404');
        }
        $client = Tukang::with('user')->where('id', Auth::id())->first();
        return view('tukang.profile.changephoto')->with(compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePhotoUser(Request $request, $id)
    {
        if (!Tukang::where('id', Auth::id())->exists()) {
            Alert::error('Error Update Profile', 'User not found !');
            return redirect()->back();
        }

        $request->validate([
            'path_foto' => 'required|mimes:jpg,jpeg,png|max:1000'
        ]);

        if ($request->hasfile('path_foto')) {
            $file = $request->file('path_foto');
            if ($file->isValid()) {
                $path = $file->store('images/photos', 'public');
                $path = substr($path, 6);
                $path = "storage/images" . $path;
                $old_file = Tukang::select('path_icon')->where('id', Auth::id())->first();
                DB::transaction(function () use ($id, $path){
                   Tukang::where('id',$id)->update(['path_icon' => $path]);
                });
                $old = substr($old_file->path_foto, 22);
                Storage::disk('public')->delete('images/photos/'.$old);
            }
            Alert::success('Succesfully Update Photo', 'Data has been saved !!!');
            return redirect()->route('show.user.ptofile', Auth::id());
        }
        Alert::error('Error Update Photo', 'File is corrupted !!!');
        return redirect()->back();
    }

}
