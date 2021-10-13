<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResourceController;
use App\Models\Admin;
use App\Models\Ban;
use App\Models\Cabang;
use App\Models\Clients;
use App\Models\HasCabang;
use App\Models\OTP;
use App\Models\PreRegistrationAdmin;
use App\Models\Tukang;
use App\Models\TukangFotoKantor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    public function login()
    {
        if (request('email') != null){
            $authh = Auth::attempt(['email' => request('email'), 'password' => request('password')]);
        }
        if (request('no_hp') != null){
            $authh = Auth::attempt(['no_hp' => request('no_hp'), 'password' => request('password')]);
        }
        if ($authh) {
            $user = Auth::user();
            $success['id'] = $user->id;
            $success['token'] = $user->createToken('nApp')->accessToken;
            if($user->email_verified_at !== NULL || $user->no_hp_verified_at){
                $success['kode_role'] = $user->kode_role;
                if ($success['kode_role'] == 2){
                    $success['kode'] = 'tukang';
                }elseif ($success['kode_role'] == 3){
                    $success['kode'] = 'client';
                }else{
                    $success['kode'] = 'admin';
                }
                return (new UserResourceController($success))->response()->setStatusCode(200);
            }else{
                $success['verified'] = false;
                return (new UserResourceController($success))->response()->setStatusCode(401);
            }
        } else {

            return (new UserResourceController(['error' => 'Unauthorised']))->response()->setStatusCode(401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'google_id' => 'string',
            'name' => 'required',
            'email' => 'email|unique:users,email',
            'nomor_telepon' => 'string|unique:users,no_hp',
            'kode_role' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'registration_use' => 'required'
        ]);

        if ($validator->fails()) {
            return (new UserResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        $record_user = User::all()->last();
        $new_id = (empty($record_user)) ? 1 : ($record_user->id + 1);

        $input = $request->all();

        if ($input['kode_role'] == 2) {
            $validator_tk = Validator::make($request->all(), [
                'alamat' => 'required',
                'nomor_telepon' => 'required|max:12',
                'lokasi' => 'required',
                'provinsi' => 'required',
                'kota' => 'required',
                'image' => 'required',
            ]);

            if ($validator_tk->fails()) {
                return (new UserResourceController(['error' => $validator_tk->errors()]))->response()->setStatusCode(401);
            }

            $user = Tukang::create([
                'id' => $new_id,
                'nomor_telepon' => $input['nomor_telepon'],
                'kota' => $input['kota'],
                'provinsi' => $input['provinsi'],
                'alamat' => $input['alamat'],
                'kode_lokasi' => $input['lokasi']
            ]);
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

        if ($input['kode_role'] == 3) {
            $validator_cl = Validator::make($request->all(), [
                'alamat' => 'required',
                'kota' => 'required',
                'provinsi' => 'required',
                'nomor_telepon' => 'required|max:12',
            ]);

            if ($validator_cl->fails()) {
                return (new UserResourceController(['error' => $validator_cl->errors()]))->response()->setStatusCode(401);
            }
            Clients::create([
                'id' => $new_id,
                'nomor_telepon' => $input['nomor_telepon'],
                'alamat' => $input['alamat'],
                'kota' => $input['kota'],
                'provinsi' => $input['provinsi']
            ]);
        }

        $input['password'] = bcrypt($input['password']);
        $input['kode_user'] = $new_id;
        $input['no_hp'] = $input['nomor_telepon'];
        if ($request->has('google_id')){
            $input['email_verified_at'] = now();
        }
        $user = User::create($input);
//        $user->sendApiEmailVerificationNotification();
//        event(new Registered($user));

        if ($input['registration_use'] == 'no_hp'){
            //send sms
            generateOTP($user->id);
            $success['message'] = 'Kode OTP Telah dikirim, Mohon Periksa Handphone anda !';
        }else if ($input['registration_use'] == 'email'){
            //send email
            $user->sendEmailVerificationNotification();
            $success['message'] = 'Konfirmasi dengan mengklik tombol pada email yang telah kami kirimkan ke anda !';
        }

        $success['verified'] = false;
        $success['token'] = $user->createToken('nApp')->accessToken;
        $success['id'] = $user->id;
        $success['name'] = $user->name;

        return (new UserResourceController($success))->response()->setStatusCode(200);
    }

    public function registerAdminCabang(Request $request, string $hash)
    {
        if (!PreRegistrationAdmin::where('email', $hash)){
            return (new UserResourceController(['error' => 'Hash Code tidak ditemukan disistem !']))->response()->setStatusCode(400);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|exists:pre_registration_admins,email',
            'kode_role' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return (new UserResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }
        $pre = PreRegistrationAdmin::where('hash', $hash)->first();

        if ($pre->access){
            return (new UserResourceController(['error' => 'Link ini sudah tidak aktif !']))->response()->setStatusCode(400);
        }

        if ($pre->email != $request->input('email')){
            return (new UserResourceController(['error' => 'Email Tidak Sama dengan Hash Code !']))->response()->setStatusCode(400);
        }

        $record_user = User::all()->last();
        $new_id = (empty($record_user)) ? 1 : ($record_user->id + 1);

        $input = $request->all();

        if ($input['kode_role'] == 4) {
            $validator_cl = Validator::make($request->all(), [
                'alamat' => 'required',
                'kota' => 'required',
                'provinsi' => 'required',
                'nomor_telepon' => 'required|max:12',
            ]);

            if ($validator_cl->fails()) {
                return (new UserResourceController(['error' => $validator_cl->errors()]))->response()->setStatusCode(401);
            }
            Admin::create([
                'id' => $new_id,
                'nomor_telepon' => $input['nomor_telepon'],
                'alamat' => $input['alamat'],
                'kota' => $input['kota'],
                'provinsi' => $input['provinsi']
            ]);
        }

        $input['password'] = bcrypt($input['password']);
        $input['kode_user'] = $new_id;
        $input['email_verified_at'] = now();
        $user = User::create($input);
        $success['verified'] = true;
        $success['token'] = $user->createToken('nApp')->accessToken;
        $success['id'] = $user->id;
        $success['name'] = $user->name;

        //add cabang
        $cabang = json_decode($pre->cabang);
        foreach ($cabang as $item){
            $hasCabang = new HasCabang();
            if (Cabang::where('nama_cabang', $item)->exists()){
                $data = Cabang::select('id')->where('nama_cabang', $item)->first();
                $hasCabang->cabang_id = $data->id;
                $hasCabang->admin_id = $new_id;
            }else{
                $newCabang = new Cabang();
                $newCabang->kode_cabang = $item;
                $newCabang->nama_cabang = $item;
                $newCabang->save();

                $hasCabang->cabang_id = $newCabang->id;
                $hasCabang->admin_id = $new_id;

            }
            $hasCabang->save();
        }
        $pre->access = true;
        $pre->save();

        return (new UserResourceController($success))->response()->setStatusCode(200);
    }

    public function details()
    {
        $user = Auth::user();
        $data['is_banned'] = Ban::where('user_id',Auth::id())->exists();
        $data['auth'] = $user;
        if ($user->kode_role == 2) {
            $data_tk = User::find($user->kode_user);
            $data['data'] = $data_tk->tukang;
        }
        if ($user->kode_role == 3) {
            $data_cl = User::find($user->kode_user);
            $data['data'] = $data_cl->client;
        }
        if ($user->kode_role == 4) {
            $data_ad = User::find($user->kode_user);
            $data['data'] = $data_ad->admin;
        }

        return (new UserResourceController($data))->response()->setStatusCode(200);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $data['auth'] = $user;

        if ($user->kode_role == 1) {
            return (new UserResourceController(['error' => 'fitur ini tidak tersedia untuk admin !!!']))->response()->setStatusCode(401);
        }


        if ($user->kode_role == 2) {
            $validator = Validator::make($request->all(), [
                'name' => 'string',
                'nomor_telepon' => 'max:12',
                'kota' => 'string',
                'provinsi' => 'string',
                'alamat' => 'string',
                'kode_lokasi' => 'string',
                'no_rekening' => 'string',
                'atas_nama_rekening' => 'string',
                'bank' => 'string'
            ]);

            if ($validator->fails()) {
                return (new UserResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
            }

            if ($user->name != $request['name']) {
                User::find($user->id)->update(['name' => $request['name']]);
            }

            Tukang::find($user->id)->update($request->except('name'));
            return (new UserResourceController(['status' => true]))->response()->setStatusCode(200);
        }
        if ($user->kode_role == 3) {
            $validator = Validator::make($request->all(), [
                'name' => 'string',
                'nomor_telepon' => 'max:12',
                'kota' => 'string',
                'provinsi' => 'string',
                'alamat' => 'string',
                'kode_lokasi' => 'string'
            ]);

            if ($validator->fails()) {
                return (new UserResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
            }

            if ($user->name != $request['name']) {
                User::find($user->id)->update(['name' => $request['name']]);
            }

            Clients::find($user->id)->update($request->except('name'));
            return (new UserResourceController(['status' => true]))->response()->setStatusCode(200);
        }
        if ($user->kode_role == 4) {
            $validator = Validator::make($request->all(), [
                'name' => 'string',
                'nomor_telepon' => 'max:12',
                'kota' => 'string',
                'provinsi' => 'string',
                'alamat' => 'string',
                'kode_lokasi' => 'string'
            ]);

            if ($validator->fails()) {
                return (new UserResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
            }

            if ($user->name != $request['name']) {
                User::find($user->id)->update(['name' => $request['name']]);
            }

            Admin::find($user->id)->update($request->except('name'));
            return (new UserResourceController(['status' => true]))->response()->setStatusCode(200);
        }
        return (new UserResourceController(['error' => 'something not working correctly']))->response()->setStatusCode(403);
    }

    public function upload_image(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'path_img' => 'required|mimes:jpg,jpeg,png|max:1000',
        ]);

        if ($validator->fails()) {
            return (new UserResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }
        $user = User::find(Auth::id());
        $role = $user->kode_role;
        $id = $user->kode_user;

        if ($role == 1) {
            return (new UserResourceController(['error' => 'fitur ini tidak tersedia untuk admin !!!']))->response()->setStatusCode(401);
        }

        if ($request->hasfile('path_img')) {
            $file = $request->file('path_img');
            $path = null;
            if ($file->isValid()) {
                $path = $file->store('images/photos', 'public');
                $path = substr($path, 6);
                $path = "storage/images" . $path;
            }
            if ($role == 2) {
                $data = Tukang::find($id);
                $data->update(['path_icon' => $path]);
            }
            if ($role == 3) {
                $data = Clients::find($id);
                $data->update(['path_foto' => $path]);
            }
            if ($role == 4) {
                $data = Admin::find($id);
                $data->update(['path_foto' => $path]);
            }
            return (new UserResourceController(['status_upload' => $data]))->response()->setStatusCode(200);
        }

    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $request->user()->token()->revoke();
        }
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
