<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResourceController;
use App\Models\Clients;
use App\Models\Tukang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('nApp')->accessToken;
            return (new UserResourceController($success))->response()->setStatusCode(200);
        } else {

            return (new UserResourceController(['error' => 'Unauthorised']))->response()->setStatusCode(401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'kode_role' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
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
                'kota' => 'required',
            ]);

            if ($validator_tk->fails()) {
                return (new UserResourceController(['error' => $validator_tk->errors()]))->response()->setStatusCode(401);
            }

            Tukang::create([
                'id' => $new_id,
                'nomor_telepon' => $input['nomor_telepon'],
                'kota' => $input['kota'],
                'alamat' => $input['alamat'],
                'kode_lokasi' => $input['lokasi']
            ]);
        }

        if ($input['kode_role'] == 3) {
            $validator_cl = Validator::make($request->all(), [
                'alamat' => 'required',
                'kota' => 'required',
                'nomor_telepon' => 'required|max:12',
            ]);

            if ($validator_cl->fails()) {
                return (new UserResourceController(['error' => $validator_cl->errors()]))->response()->setStatusCode(401);
            }
            Clients::create([
                'id' => $new_id,
                'nomor_telepon' => $input['nomor_telepon'],
                'alamat' => $input['alamat'],
                'kota' => $input['kota']
            ]);
        }

        $input['password'] = bcrypt($input['password']);
        $input['kode_user'] = $new_id;
        $user = User::create($input);

        $success['token'] = $user->createToken('nApp')->accessToken;
        $success['name'] = $user->name;

        return (new UserResourceController($success))->response()->setStatusCode(200);
    }

    public function details()
    {
        $user = Auth::user();
        $data['auth'] = $user;
        if ($user->kode_role == 2) {
            $data_tk = User::find($user->kode_user);
            $data['data'] = $data_tk->tukang;
        }
        if ($user->kode_role == 3) {
            $data_cl = User::find($user->kode_user);
            $data['data'] = $data_cl->client;
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
                'alamat' => 'string',
                'kode_lokasi' => 'string'
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
            return (new UserResourceController(['status_upload' => $data]))->response()->setStatusCode(200);
        }

    }
}
