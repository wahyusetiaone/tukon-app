<?php

namespace App\Http\Middleware;

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
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(\Illuminate\Contracts\Auth\Factory $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (! $request->user($guard)) {
            if($request->expectsJson()) {
                return response()->json([
                    'message' => 'You do not have permission to access this feature.',
                    'errors' => [
                        'main' => ['The access token is either missing or incorrect.']
                    ]
                ], 401);
            } else {
                return redirect(route('login'));
            }
        } else if
        (! $request->user($guard)->hasVerifiedEmail()) {

            if($request->expectsJson()) {
                return response()->json([
                    'message' => 'You do not have permission to access this feature.',
                    'errors' => [
                        'main' => ['Your email address is not verified.']
                    ]
                ], 403);
            } else {
                return redirect(route('verification.notice'));
            }
        }

        $this->auth->shouldUse($guard);

        return $next($request);
    }
}
