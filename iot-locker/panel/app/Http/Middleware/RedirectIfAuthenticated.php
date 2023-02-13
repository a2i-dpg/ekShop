<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if(Auth::guard($guard)->check() && Auth::user()->role->role_slug === 'super-admin'){
                return redirect(RouteServiceProvider::superHome);
            }else if(Auth::guard($guard)->check() && Auth::user()->role->role_slug === 'company-admin' && Auth::user()->user_is_active ===1){
                return redirect(RouteServiceProvider::adminDashboard);
            }
            else if(Auth::guard($guard)->check() && Auth::user()->role->role_slug === 'company-agent' && Auth::user()->user_is_active ===1){
                return redirect(RouteServiceProvider::agentDashboard);
            }else if(Auth::guard($guard)->check() && Auth::user()->role->role_slug === 'locker-master' && Auth::user()->user_is_active ===1){
                return redirect(RouteServiceProvider::lockerMasterDashboard);
            }
            else{
                return $next($request);
            }
        }   
    }
}
