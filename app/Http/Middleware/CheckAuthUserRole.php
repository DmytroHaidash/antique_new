<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class CheckAuthUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::user()->hasRole(explode('|', $role))) {
            return redirect()->route('client.index');
        }
        return $next($request);
    }
}
