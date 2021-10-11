<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OTP;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME_VERIFICATION;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    //this is verification number phone
    public function verification(Request $request){

        $this->validate($request, [
            'code' => 'required|max:8'
        ]);

        if (!OTP::where('code', $request->input('code'))->exists()){
            return redirect()->back()->with(['error' => 'Kode Tidak ditemukan !']);
        }
        $otp = OTP::where('code', $request->input('code'))->first();

        if (Auth::id() == $otp->user_id){
            $user = User::whereId(Auth::id())->first();
            $user->no_hp_verified_at =  Carbon::now()->toDateTime();
            $user->save();
            if ($user->kode_role == 2){
                return redirect()->route('home');
            }
            if ($user->kode_role == 3){
                return redirect()->route('homeclient');
            }
        }else{
            return redirect()->back()->with(['error' => 'Kode Tidak cocok !']);
        }
    }

    //end of verifiaction number phone
}
