<?php

namespace App\Http\Middleware;

use App\Models\Ban;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsUserBannedApi
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $respon = $next($request);

        $message = 'Akunmu telah di suspend, mohon kontak Admin Tukon untuk informasi lebih lanjut.';
        if ($request->expectsJson()) {
            if (auth()->check() && Ban::where('user_id',auth()->id())->exists()) {
                return response()->json([
                    'message' => $message
                ], 403);
            }
        }

        return $respon;
    }
}
