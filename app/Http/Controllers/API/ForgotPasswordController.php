<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;

class ForgotPasswordController extends Controller
{
    protected function sendResetLinkResponse(Request $request)
    {
        $input = $request->only('email');
        $validator = Validator::make($input, [
            'email' => "required|email"
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        if (!User::where('email', $input)->exists()){
            $data = 'Account within email not found';
        }else{
            $data = User::select('name')->where('email', $input)->first();
        }
        $response =  Password::sendResetLink($input);
        if($response == Password::RESET_LINK_SENT){
            $message = "Mail send successfully";
        }else{
            $message = "Email could not be sent to this email address.";
        }
        //$message = $response == Password::RESET_LINK_SENT ? 'Mail send successfully' : GLOBAL_SOMETHING_WANTS_TO_WRONG;
        $response = ['data'=>$data,'message' => $message];
        return response($response, 200);
    }
}
