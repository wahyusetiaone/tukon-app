<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\OTP;
use App\Models\Roles;
use App\Models\Tukang;
use App\Models\TukangFotoKantor;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
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
    protected $redirectTo = RouteServiceProvider::HOME_REGISTER;
//    protected function redirectTo()
//    {
//        if (auth()->user()->role->id == 3) {
//            return '/client/home';
//        }
//        return '/home';
//    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['data' => 'example']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'integer'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'alamat' => ['string', 'max:255'],
            'kota' => ['string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $record_user = User::all()->last();
        $new_id = (empty($record_user)) ? 1 : ($record_user->id + 1);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'no_hp' => $data['no_hp'],
            'kode_role' => $data['role'],
            'kode_user' => $new_id,
            'registration_use' => $data['type_reg'],
            'password' => Hash::make($data['password']),
        ]);


        if ($user->kode_role == 2) {
            Tukang::create([
                'id' => $new_id,
                'nomor_telepon' => $data['nomor_telepon'],
                'provinsi' => $data['provinsi'],
                'kota' => $data['kota'],
                'alamat' => $data['alamat_tk']
            ]);
        }

        if ($user->kode_role == 3) {
            Clients::create([
                'id' => $new_id,
                'nomor_telepon' => $data['nomor_telepon'],
                'provinsi' => $data['provinsi'],
                'kota' => $data['kota'],
                'alamat' => $data['alamat_cl'],
            ]);
        }

        return $user;
    }

    public function showRegistrationForm(Request $request)
    {
        $roles = Roles::all();
        $data = [
            'data' => $roles,
            'registerAs' => $request->session()->get('registerAs'),
            'name' => $request->session()->get('name'),
            'email' => $request->session()->get('email'),
            'no_hp' => $request->session()->get('no_hp'),
            'type_reg' => $request->session()->get('type_reg'),
            'provinsi' => callMomWithGet(env('API_PROVINSI'))
        ];
        return view("auth.panel.reguster_component.form", with($data));
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function checkEmail(Request $request)
    {
        $this->validate($request, [
            'typeof' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users']
        ]);

        $registerAs = $request->input('typeof');
        $name = $request->input('name');
        $email = $request->input('email');
        $type_reg = 'email';

        return redirect()->route('register')
            ->with('registerAs', $registerAs)
            ->with('name', $name)
            ->with('type_reg', $type_reg)
            ->with('email', $email);
    }
    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function checkNoHp(Request $request)
    {
        $this->validate($request, [
            'typeof' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:255', 'unique:users']
        ]);

        $registerAs = $request->input('typeof');
        $no_hp = $request->input('no_hp');
        $type_reg = 'no_hp';

        return redirect()->route('register')
            ->with(compact('registerAs', 'no_hp', 'type_reg'));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        if (!$request->has('email')){
            $request['email'] = NULL;
        }
        if (!$request->has('nomor_telepon')){
            $request['no_hp'] = NULL;
        }else{
            $request['no_hp'] = $request->input('nomor_telepon');
        }

        $user = $this->create($request->all());

//        event(new Registered($user));

        if ($request->input('type_reg') == 'no_hp'){
            //send sms
            //dummy buat code OTP
            $otp = new OTP();
            $otp->user_id = $user->id;
            $otp->code = 'T-999999';
            //expired 5 minute
            $otp->expired_at = Carbon::now()->addMinutes(5);
            $otp->save();

        }else if ($request->input('type_reg') == 'email'){
            //send email
            $user->sendEmailVerificationNotification();
        }

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        //save foto kantor
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {
                $path = $file->store('tukang/kantor', 'public');
                $path = substr($path, 6);
                $path = "storage" . $path;

                TukangFotoKantor::create([
                    'tukang_id' => $user->id,
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName()
                ]);
            }
        }
    }
}
