<?php

namespace App\Http\Middleware;

use App\Models\Location;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class GuestMiddleware
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
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            if (!in_array($locale, ['en', 'bn'])) {
                abort(400);
            }
            App::setLocale($locale);
        }

        $showVideo = 0;
        Session::put('session_time', 2);

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

        return $next($request);
    }
}
