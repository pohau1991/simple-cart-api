<?php

namespace App\Services;


class ApiService
{
    protected $acceptableCodes = [
        200, // ok
        204, // No content
        400, // bad request
        401, // incorrect data
    ];

    /**
     * Global api wrapper
     *
     * @param $data
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeResponse($data, $message = "ok", $code = 200){
        if(!$this->isCodeAcceptable($code)){
            return response()->json([
                'code' => 400,
                'message' => $code. " - is not an acceptable code.",
                'data' => $data
            ]);
        }

        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * Check if the code passed is an acceptable HTTP STATUS CODE
     *
     * @param $code
     * @return bool
     */
    public function isCodeAcceptable($code){
        return in_array($code, $this->acceptableCodes);
    }

    public function postCall($url, $data){
        //$sslVerify = getenv('SSL_VERIFY') ? env('SSL_VERIFY') : true;
        $ch = @curl_init();

        @curl_setopt($ch, CURLOPT_POST, true);
        @curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        @curl_setopt($ch, CURLOPT_URL, $url);
        @curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        @curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        @curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        

        $response = @curl_exec($ch);
        $status_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errors = curl_error($ch);
        @curl_close($ch);
        return $response ? $response : $curl_errors;
    }
    public function getCall($url, $data){
        //$sslVerify = getenv('SSL_VERIFY') ? env('SSL_VERIFY') : true;
        
        
        $ch = curl_init();
        @curl_setopt($ch, CURLOPT_URL, $url.$data);
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        @curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        @curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            //@curl_setopt($ch, CURLOPT_HTTPGET, false);
        
        $response = @curl_exec($ch);
        $status_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errors = curl_error($ch);
        @curl_close($ch);
        return $response ? $response : $curl_errors;
    }
}