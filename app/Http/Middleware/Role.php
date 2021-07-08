<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $roles = $this->CekRoute($request->route());

        if($request->user()->hasRole($roles) || !$roles)
        {
            return $next($request);
        }
        return abort(503, 'Anda tidak memiliki hak akses');
//        return response()->view('errors.503', ['message' => 'Anda tidak memiliki hak akses'], 503);
    }

    private function CekRoute($route)
    {
        $actions = $route->getAction();
        return isset($actions['roles']) ? $actions['roles'] : null;
    }
}
