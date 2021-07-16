<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\Roles;
use App\Models\Tukang;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest',['data' => 'example']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'integer'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nomor_telepon' => ['integer', 'max:12'],
            'alamat' => ['string', 'max:255'],
            'kota' => ['string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $record_user = User::all()->last();
        $new_id = (empty($record_user)) ? 1 : ($record_user->id + 1);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'kode_role' => $data['role'],
            'kode_user' => $new_id,
            'password' => Hash::make($data['password']),
        ]);


        if ($user->kode_role == 2){
            Tukang::create([
                'id'=>$new_id,
                'nomor_telepon'=>$data['nomor_telepon_tk'],
                'kota'=>$data['kota_tk'],
                'alamat'=>$data['alamat_tk']
            ]);
        }

        if ($user->kode_role == 3){
            Clients::create([
                'id'=>$new_id,
                'nomor_telepon'=>$data['nomor_telepon_cl'],
                'alamat'=>$data['alamat_cl'],
                'kota'=>$data['kota_cl'],
            ]);
        }

        return $user;
    }

    public function showRegistrationForm()
    {
        $roles = Roles::all();
        $data = [
            'data' => $roles
        ];
        return view("auth.register", with($data));
    }
}
