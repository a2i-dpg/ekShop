<?php

namespace App\Helpers;

use App\Models\Location;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class BarcodeLinkGenerator
{
    public static $apiEndpoint = 'https://s-1b.com/api/get-bar-code';

    public static function GRcode($data)
    {
        $LocalLocationData = Location::first();

        try {
            $response = Http::withHeaders([
                'passcode' => 'short_link_2022'
            ])->post(self::$apiEndpoint, [
                'location' => $LocalLocationData->location_address,
                'barcode' => $data
            ]);

            if ($response->successful()) {
                $shortLink = json_decode($response);
                return $shortLink->data;
            }
        } catch (ConnectionException $e) {
            return $e->getMessage();
        }
    }
}
