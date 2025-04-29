<?php

// https://github.com/OkFone5s/RevivalProxy

namespace RevivalProxy {
    class Proxy {
        private $URL = "";

        public function __construct ($api) {
            $this->URL = (string)$api;
        }

        public function Request ($endpoint, $data) {
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json");
            header("Access-Control-Allow-Methods: GET");
            header("Access-Control-Allow-Headers: Content-Type");
            
            $api = $this->URL.$endpoint."?".http_build_query($data);

            $request = curl_init();
            curl_setopt_array($request, [
                CURLOPT_URL => $api,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'X-Forwarded-For: ' . $_SERVER['REMOTE_ADDR']
                ],
                CURLOPT_TIMEOUT => 5,
                CURLOPT_MAXFILESIZE => 1024
            ]);

            $response = curl_exec($request);
            $status = curl_getinfo($request, CURLINFO_HTTP_CODE);

            curl_close($request);

            http_response_code($status);
            die($response);
        }
    }
}

?>
