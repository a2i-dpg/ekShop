<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check() && Auth::user()->role->role_slug === 'company-admin'){
            return $next($request);
        }else if(Auth::check() && Auth::user()->user_is_active === 0){
            Session::flush();
            return redirect()->route('login');
        }else{

            Session::flush();
            return redirect()->route('login')->with('message',"You don't have admin right");
        }
    }
}
