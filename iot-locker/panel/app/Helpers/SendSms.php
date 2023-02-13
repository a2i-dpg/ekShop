<?php

namespace App\Helpers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class SendSms
{
    public static $baseURL = ''; //
    public static $client = '';
    public static $passkey = '';
    
    public static function sendSms($contact_no, $smsBody){
        

        try {
            $response = Http::get(self::$baseURL, [
                'passkey' => self::$passkey,
                'smsText' => $smsBody,
                'client' => self::$client,
                'number' => $contact_no,
            ]);

            if ($response->successful()) {
                $smsReturn = json_decode($response);
                return $smsReturn;
            }

            $error = [
                'code' => '408',
                'reason' => 'Please try again later'
            ];
            return (object) $error;
        } catch (ConnectionException $e) {

            $error = [
                'code' => '408',
                'reason' => 'SMS connection error'
            ];
            return (object) $error;
        }
    }
}
