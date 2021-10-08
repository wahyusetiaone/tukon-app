<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResourceController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OAuthGoogleController extends Controller
{
    public function check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return (new UserResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        if (User::where('email', $request->input('email'))) {
            Auth::login(User::where('email', $request->input('email'))->first());
            $user = Auth::user();
            $success['token'] = $user->createToken('nApp')->accessToken;
            if($user->email_verified_at !== NULL){

                $success['kode_role'] = $user->kode_role;
                if ($success['kode_role'] == 2){
                    $success['kode'] = 'tukang';
                }elseif ($success['kode_role'] == 3){
                    $success['kode'] = 'client';
                }else{
                    $success['kode'] = 'admin';
                }
                $success['registered'] = true;
                $success['verified'] = true;
                return (new UserResourceController($success))->response()->setStatusCode(200);
            }else{
                $success['registered'] = true;
                $success['verified'] = false;
                $success['message'] = 'Please confirm yourself by clicking on verify user button sent to you on your email';
                return (new UserResourceController($success))->response()->setStatusCode(401);
            }
        } else {

            return (new UserResourceController(['error' => 'Unauthorised Email, Please Register', 'registered' => false]))->response()->setStatusCode(401);
        }
    }
}
