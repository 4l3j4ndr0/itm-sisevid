<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class Util
{
    public static function sendSms(String $number, String $cel)
    {
        $response = Http::withHeaders(
            [
                "account" => env("CLIENTE_HABLAME"),
                "apiKey" => env("API_HABLAME"),
                "token" => env("TOKEN_HABLAME"),
            ]
        )->post(env('URL_HABLAME_NEW'), [
            "account" => env("CLIENTE_HABLAME"),
            "apiKey" => env("API_HABLAME"),
            "token" => env("TOKEN_HABLAME"),
            "toNumber" => $number,
            "sms" => $cel,
            "flash" =>  0,
            "request_dlvr_rcpt" => 0,
        ]);
    }
}
