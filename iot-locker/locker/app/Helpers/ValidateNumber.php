<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class ValidateNumber
{
    /*
    // Number Validate using API
    public static function validateNumber($data){
        $response = Http::get('https://smsc.ekshop.gov.bd/number-validation',['number'=>$data]);
        $response = json_decode($response,true);
        return $response;
    }
    */

    public static function validateNumber($number)
    {
        $mobile = $number;

        $search_array = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $replace_array = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $mobile = str_replace($search_array, $replace_array, $mobile);
        $mobile = str_replace("-", "", $mobile);
        $mobile = str_replace(" ", "", $mobile);
        $mobile = str_replace(".", "", $mobile);

        $opCode = substr($mobile, 0, 5);
        if (substr($opCode, 0, 2) == '88') {
            $mobile = ltrim($mobile, '88');
        } else if (substr($opCode, 0, 3) == '+88') {
            $mobile = ltrim($mobile, '+88');
        } else if (substr($opCode, 0, 2) == '00') {
            $mobile = ltrim($mobile, '00');
        }

        if (substr($mobile, 0, 1) != '0') {
            $mobile = '0' . $mobile;
        }

        $OperatorArr = [
            '013', '014', '015', '016', '017', '018', '019'
        ];

        $validateNumber = substr($mobile, 0, 3);

        if (in_array($validateNumber, $OperatorArr)) {
            $response = response()->json([
                'code' => 200,
                'requested_number' => $number,
                'formatted_number' => $mobile
            ], 200);
        } else {
            $response = response()->json([
                'code' => 406,
                'requested_number' => $number,
                'reason' => 'Invalid number'
            ], 406);
        }

        return $response;
        // return self::filterJson($response);
    }

    // Json Formate/Filter for Decode
    public function filterJson($data)
    {
        $newJsonFile = '';
        $flag = 0;

        $data = (string)$data;

        for ($i = 0; $i < strlen($data); $i++) {
            if ($data[$i] == '{' || $flag == 1) {
                $newJsonFile .= $data[$i];
                $flag = 1;
            }
        }

        return $newJsonFile;
    }
}
