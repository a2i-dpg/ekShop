<?php

namespace App\Helpers;

use App\Models\GeneralSetting;
use App\Models\Location;

class HttpHeader
{
    public static function pudoLocalHeader()
    {
        $locationInfo = Location::first();
        $gsInfo = $locationInfo->generalSetting->where('setting_name', 'client_info')->first();
        $clintInfo = json_decode($gsInfo->setting_value);

        return [
            'appKey' => env('APP_KEY'),
            'clientSecret' => $clintInfo->client_secret,
            'client' => $clintInfo->client_name,
            'locationId' => $clintInfo->locker_id
        ];
    }
}
