<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyAccountMiddleware
{
    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param \Illuminate\Contracts\Auth\Factory $auth
     * @return void
     */
    public function __construct(\Illuminate\Contracts\Auth\Factory $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $redirectToRoute
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $respon = $next($request);
        if (!$request->user($guard)) {
            if ($request->expectsJson()) {
                return response()->json($respon->original, 401);
            } else {
                return redirect(route('panel.login'));
            }
        } else {
            if (User::whereId(Auth::id())->hasEmail()->exists() && !User::whereId(Auth::id())->hasNoHp()->isVerifiedNoHp()->exists()){
                if (!User::whereId(Auth::id())->hasEmail()->isVerifiedEmail()->exists()){
                    if ($request->expectsJson()) {
                        $respon->original['message'] = 'Email Belum di verifikasi';
                        return response()->json($respon->original, 401);
                    } else {
                        return redirect(route('verification.notice.email'));
                    }
                }
            }

            if (User::whereId(Auth::id())->hasNoHp()->exists() && !User::whereId(Auth::id())->hasEmail()->isVerifiedEmail()->exists()){
                if (!User::whereId(Auth::id())->hasNoHp()->isVerifiedNoHp()->exists()){
                    if ($request->expectsJson()) {
                        $respon->original['message'] = 'Nomor Handphone Belum di verifikasi';
                        return response()->json($respon->original, 401);
                    } else {
                        return redirect(route('verification.notice.nohp'));
                    }
                }
            }
        }

        $this->auth->shouldUse($guard);

        return $respon;
    }
}
