<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Active
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
        if(Auth::user()->is_active == '1'){
            return $next($request);
        }

        Auth::logout();
        return redirect('login')->withErrors(['username' =>  'Your account has been disabled. Please Contact Admin.']);
    }
}
