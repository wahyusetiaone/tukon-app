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

    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('nApp')->accessToken;
            return (new UserResourceController($success))->response()->setStatusCode(200);
        }
        else{

            return (new UserResourceController(['error'=>'Unauthorised']))->response()->setStatusCode(401);
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
            return (new UserResourceController(['error'=>$validator->errors()]))->response()->setStatusCode(401);
        }

        $record_user = User::all()->last();
        $new_id = (empty($record_user)) ? 1 : ($record_user->id + 1);

        $input = $request->all();

        if ($input['kode_role'] == 2){
            $validator_tk = Validator::make($request->all(), [
                'alamat' => 'required',
                'nomor_telepon' => 'required|max:12',
                'kota' => 'required',
            ]);

            if ($validator_tk->fails()) {
                return (new UserResourceController(['error'=>$validator_tk->errors()]))->response()->setStatusCode(401);
            }

            Tukang::create([
                'id'=>$new_id,
                'nomor_telepon'=>$input['nomor_telepon'],
                'kota'=>$input['kota'],
                'alamat'=>$input['alamat']
            ]);
        }

        if ($input['kode_role'] == 3){
            $validator_cl = Validator::make($request->all(), [
                'alamat' => 'required',
                'nomor_telepon' => 'required|max:12',
            ]);

            if ($validator_cl->fails()) {
                return (new UserResourceController(['error'=>$validator_cl->errors()]))->response()->setStatusCode(401);
            }
            Clients::create([
                'id'=>$new_id,
                'nomor_telepon'=>$input['nomor_telepon'],
                'alamat'=>$input['alamat']
            ]);
        }

        $input['password'] = bcrypt($input['password']);
        $input['kode_user'] = $new_id;
        $user = User::create($input);

        $success['token'] =  $user->createToken('nApp')->accessToken;
        $success['name'] =  $user->name;

        return (new UserResourceController($success))->response()->setStatusCode(200);
    }

    public function details()
    {
        $user = Auth::user();
        $data['auth'] = $user;
        if ($user->kode_role == 2){
            $data_tk = User::find($user->kode_user);
            $data['data'] = $data_tk->tukang;
        }
        if ($user->kode_role == 3){
            $data_cl = User::find($user->kode_user);
            $data['data'] = $data_cl->client;
        }

        return (new UserResourceController($data))->response()->setStatusCode(200);
    }
}
