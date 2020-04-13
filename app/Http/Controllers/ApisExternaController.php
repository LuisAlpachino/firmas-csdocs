<?php

namespace App\Http\Controllers;

use App\Util;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use GuzzleHttp\Http\Exception\BadResponseException;

class ApisExternaController extends Controller
{
    public function rfc(Request $request, $id){
	if($request->isJson()){
	    $token = 'bearer T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRiMTFPRlV3a2kyOWI5WUZHWk85ODJtU0M2UlJEUkFTVXhYTDNKZVdhOXIySE1tUVlFdm1jN3kvRStBQlpLRi9NeWJrd0R3clhpYWJrVUMwV0Mwd3FhUXdpUFF5NW5PN3J5cklMb0FETHlxVFRtRW16UW5ZVjAwUjdCa2g0Yk1iTExCeXJkVDRhMGMxOUZ1YWlIUWRRVC8yalFTNUczZXdvWlF0cSt2UW0waFZKY2gyaW5jeElydXN3clNPUDNvU1J2dm9weHBTSlZYNU9aaGsvalpQMUxrSkhlVUY2aXpLNWZkaHZlcDFtMWFhWkJpdGFxSFpRMXZSWUp5QUZsalZWd2huVWx3NUM3dVF6aWxJaGJqUU9QbFdWZW0zMTQxTmd6dUJ3dHR0SDlvTjhLUzFoT3VsMnRXWFlTWGFOUDNaeEhmUklFOWVEZjB6OE9QVGhzWnZ1bjRzWkUyeWd3UXlFMUtENVRXQ1pxRjg9.6Us1aA5VkXQTHyEBeaq-98l_5NTADHRAayJXQPT9qIA';
        $headers = ['headers' => ['Authorization' => $token]];
        $client = new  Client([
            'base_uri' => 'http://services.test.sw.com.mx/lrfc/',
            'time-out' => '2.0'
        ]);
        try {
            $response = $client->request('GET',strtoupper($id),  $headers);
        }catch (\GuzzleHttp\Exception\BadResponseException $e){
            return response()->json(['status' => 'No se encontro el rfc'],200);
        }
        return $response->getBody()->getContents();
	}
	return response()->json(['error' => 'Unauthorized'],'401');
    }

    public function cp(Request $request, $id){
        if($request->isJson()){
            $client = new Client([
                // Base URI is used with relative requests
                'base_uri' => 'https://api-sepomex.hckdrk.mx/query/get_colonia_por_cp/',
            ]);
            $response = $client->request('GET', $id);


            return  json_decode($response->getBody()->getContents(),true);
        }
        return response()->json(['error' => 'Unauthorized'],'401');
    }

    public function curp( $curp){
        $util = new Util();
        if ($util->validarCURP($curp))
            return response()->json('curp Valida', 200);
        return response()->json('invalido', 401);


    }

}
