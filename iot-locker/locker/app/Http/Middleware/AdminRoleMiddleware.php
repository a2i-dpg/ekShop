<?php

namespace App\Http\Middleware;

use App\Models\Location;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminRoleMiddleware
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
        $showVideo = 0;
        $lifetime = 5;
        Session::put('session_time', $lifetime);

        $locationInfo = Location::first();

        if (isset($locationInfo)) {
            $gsInfo = $locationInfo->generalSetting->where('setting_name', 'client_info')->first();
            $clintInfo = json_decode($gsInfo->setting_value);

            $gsVideoInfo = $locationInfo->generalSetting->where('setting_name', 'help_video')->first();

            if (isset($gsVideoInfo)) {
                $videoInfo = json_decode($gsVideoInfo->setting_value);
                $showVideo = $videoInfo->show_video;
            }

            Session::put('appKey', env('APP_KEY'));
            Session::put('clientSecret', $clintInfo->client_secret);
            Session::put('client', $clintInfo->client_name);
            Session::put('locationId', $clintInfo->locker_id);
        }

        Session::put('show_video', $showVideo);

        if (Auth::user()->role_id === 2) {
            return $next($request);
        } else {
            Session::flush();
            return redirect('/admin/login');
        }
    }
}
