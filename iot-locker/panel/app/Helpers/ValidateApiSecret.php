<?php

namespace App\Helpers;

use App\Models\ApiSecretHeader;
use App\Models\GenerelSettings;
use Illuminate\Support\Facades\Http;

class ValidateApiSecret
{

    public static function validateHeader($request,$data){
        
        $clientName = $request->header('client');
        $clientAuth = $request->header('clientSecret');
        //check if client valid
        if($data->api_auth != $clientName){
            return 'client name invalid';
        }

        //check if auth token valid
        if($data->secret_api_key != $clientAuth){
            return 'Invalid Key';
        }
    }


    public static function validateAppKey($request){

        if(!$request->header('appKey')){
            return 'App Key Missing';
        }
        $appKey = GenerelSettings::where('setting_name','appKey')->first('setting_value');
        if($request->header('appKey')!=$appKey->setting_value){
            return 'App Key wrong';
        }
        if(env('APP_KEY')!=$appKey->setting_value){
            return 'ENV App Key and Database App key not matched';
        }
    }


}
