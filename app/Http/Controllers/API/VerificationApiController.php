<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OTP;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;

class VerificationApiController extends Controller
{
    use VerifiesEmails;

    /**
     * Show the email verification notice.
     *
     */
    public function show()
    {
//
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        $user = User::findOrFail($request['id']);

        $verified = true;
        if (! hash_equals((string) $request['id'],
            (string) $user->getKey())) {
            $verified = false;
        }

//        if (! hash_equals((string) $request['hash'],
//            sha1($user->getEmailForVerification()))) {
//            $verified = false;
//        }

        if (! $user->hasVerifiedEmail()) {
            if ($verified){
                $user->markEmailAsVerified();

                event(new Verified($user));
            }
        }

        return response()->json('Email verified!');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function verify_hash(Request $request)
    {
        $user = User::findOrFail($request['id']);

        $verified = true;
        if (! hash_equals((string) $request['id'],
            (string) $user->getKey())) {
            $verified = false;
        }

        if (! hash_equals((string) $request['hash'],
            sha1($user->getEmailForVerification()))) {
            $verified = false;
        }

        if (! $user->hasVerifiedEmail()) {
            if ($verified){
                $user->markEmailAsVerified();

                event(new Verified($user));
            }
        }

        return response()->json('Email verified!');
    }

    /**
     * Resend the email verification notification.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json('User already have verified email!', 422);
        }
        $request->user()->sendEmailVerificationNotification();
        return response()->json('The notification has been resubmitted');
    }

    //OTP
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyOTP(Request $request, int $id)
    {
        $this->validate($request, [
            'code' => 'required|string|max:8'
        ]);

        if (!OTP::where('code', $request->input('code'))->exists()){
            return response()->json(['error' => 'Kode tidak ditemukan!'], 401);
        }
        $otp = OTP::where('code', $request->input('code'))->first();

        if ($id == $otp->user_id){
            $user = User::whereId(Auth::id())->first();
            $user->no_hp_verified_at =  Carbon::now()->toDateTime();
            $user->save();
            return response()->json(['success' => 'Nomor Handphone berhasil diverifikasi'], 200);
        }else{
            return response()->json(['error' => 'Kode tidak cocok!'], 401);
        }
    }
}
