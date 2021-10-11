<?php

namespace App\Http\Middleware;

use App\Models\Ban;
use Closure;
use Illuminate\Http\Request;

class IsUserBanned
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $message = 'Akunmu telah di suspend, mohon kontak Admin Tukon untuk informasi lebih lanjut.';

        if (auth()->check() && Ban::where('user_id', auth()->id())->exists()) {
            auth()->logout();
            return redirect()->route('panel.login')->with('message', $message);
        }

        return $next($request);
    }
}
