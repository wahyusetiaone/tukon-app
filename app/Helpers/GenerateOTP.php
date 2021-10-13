<?php

use App\Models\OTP;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

if (!function_exists("generateOTP")) {
    function generateOTP($id)
    {
        do{
            $code = substr(number_format(time() * rand(),0,'',''),0,6);
        }while(OTP::where('code', $code)->exists());
        //dummy buat code OTP
        $otp = new OTP();
        $otp->user_id = $id;
        $otp->code = $code;
        //expired 5 minute
        $otp->expired_at = Carbon::now()->addMinutes(5);
        $otp->save();
    }
}

