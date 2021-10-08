<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\Tukang;
use App\Models\TukangFotoKantor;
use App\Models\User;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class OAuthGoogleController extends Controller
{
    public function google(string $as)
    {
        Session::put('user_as', $as);
        return Socialite::driver('google')->redirect();
    }

    public function google_callback(Request $request)
    {
        if (Session::has('user_as')) {
            $user_as = session('user_as');
            Session::forget('user_as');
        }
        $kode_role = $this->getRoles($user_as);

        try {

            $user = Socialite::driver('google')->user();

            /// lakukan pengecekan apakah email nya sudah ada apa belum
            $isUser = User::where('email', $user->getEmail())->first();

            /// jika sudah ada, langsung login
            if ($isUser) {

                Auth::login($isUser);
                if ($isUser->kode_role == 1 || $isUser->kode_role == 2){
                    return redirect('/home');
                }elseif($isUser->kode_role == 3){
                    return redirect('/');
                }

            } else { /// jika belum ada, register baru

                $createUser = new User;

                //set a role
                $createUser->kode_role = $kode_role;

                $createUser->name = $user->getName();

                /// mendapatkan email dari google
                if ($user->getEmail() != null) {
                    $createUser->email = $user->getEmail();
                    $createUser->email_verified_at = \Carbon\Carbon::now();
                }

                /// tambahkan google id
                $createUser->google_id = $user->getId();

                /// membuat random password
                $rand = rand(111111, 999999);
                $createUser->password = Hash::make($user->getName() . $rand);

                /// save
                $createUser->save();

                /// login
                Auth::login($createUser);

                //redirect
                if ($kode_role == 1 || $kode_role == 2){
                    return redirect('/home');
                }elseif($kode_role == 3){
                    return redirect('/');
                }
            }

        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function moreregister(int $id){
        $data = User::whereId($id)->first();
        $registerAs = $this->getRolesName($data->kode_role);
        $name = $data->name;
        $email = $data->email;
        $provinsi = callMomWithGet(env('API_PROVINSI'));
        return view('auth.panel.reguster_component.form_google')->with(compact('registerAs', 'name', 'email', 'provinsi'));
    }

    public function store_moreregister(Request $request,int $id){
        $data = User::whereId($id)->first();
        $data->update(['kode_user' => $data->id]);

        //redirect
        if ($data->kode_role == 2){
            Tukang::create([
                'id' => $data->id,
                'nomor_telepon' => $request->input('nomor_telepon_tk'),
                'provinsi' => $request->input('provinsi'),
                'kota' => $request->input('kota'),
                'alamat' => $request->input('alamat_tk')
            ]);
            //save foto kantor
            if ($request->hasfile('image')) {
                $file = $request->file('image');
                if ($file->isValid()) {
                    $path = $file->store('tukang/kantor', 'public');
                    $path = substr($path, 6);
                    $path = "storage" . $path;

                    TukangFotoKantor::create([
                        'tukang_id' => $data->id,
                        'path' => $path,
                        'original_name' => $file->getClientOriginalName()
                    ]);
                }
            }
            return redirect('/home');
        }elseif($data->kode_role == 3){
            Clients::create([
                'id' => $data->id,
                'nomor_telepon' => $request->input('nomor_telepon_cl'),
                'provinsi' => $request->input('provinsi'),
                'kota' => $request->input('kota'),
                'alamat' => $request->input('alamat_cl'),
            ]);
            return redirect('/');
        }
    }

    function getRoles(string $user_as)
    {
        switch ($user_as) {
            case 'client':
                return 3;
            case 'tukang' :
                return 2;
        }
    }
    function getRolesName(int $role_id)
    {
        switch ($role_id) {
            case 3:
                return 'client';
            case 2 :
                return 'tukang';
        }
    }
}
