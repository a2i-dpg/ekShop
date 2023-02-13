<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class ValidateNumber
{

    public static function validNumber($number)
    {
        $mobile = $number;

        $search_array = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $replace_array = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $mobile = str_replace($search_array, $replace_array, $mobile);
        $mobile = str_replace("-", "", $mobile);
        $mobile = str_replace(" ", "", $mobile);
        $mobile = str_replace(".", "", $mobile);

        $opCode = substr($mobile, 0, 5);
        if (substr($opCode, 0, 2) == 88) {
            $mobile = ltrim($mobile, '88');
        } else if (substr($opCode, 0, 3) == +88) {
            $mobile = ltrim($mobile, '+88');
        } else if (substr($opCode, 0, 2) == 00) {
            $mobile = ltrim($mobile, '00');
        }

        if (substr($mobile, 0, 1) != 0) {
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
    }
}
