<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;


class Encryption
{


public static function apiEncryption($data){

    //layer 1 encryption using md5
    $md5Encrypt = base64_encode($data);
    //layer 2 encryption using crypto
    return Crypt::encryptString($md5Encrypt);

}

public static function apiDecryption($data){

   //layer 2 decryption using crypto
    $cryptoDecrypt = Crypt::decryptString($data);
   //layer 1 decryption using md5
   return base64_decode($cryptoDecrypt);
}

}
