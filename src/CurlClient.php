<?php

namespace alexshent\tbot;

class CurlClient implements RestClient {

    private $curlHandle;

    public function __construct() {
        $this->curlHandle = curl_init();
    }

    public function __destruct() {
        curl_close($this->curlHandle);
    }

    public function get(string $url, array $headers = []): string {
        curl_setopt_array($this->curlHandle, [
            CURLOPT_URL => $url,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers
        ]);
        $result = curl_exec($this->curlHandle);
        return $result;
    }

    public function post(string $url, array $data, array $headers = []): string {
        $json = json_encode($data);
//file_put_contents('curl-out.txt', print_r($json, 1)."\n", FILE_APPEND);
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Content-Length: ' . strlen($json);

        curl_setopt_array($this->curlHandle, [
            CURLOPT_URL => $url,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => $headers
        ]);

        $result = curl_exec($this->curlHandle);
        return $result;
    }
}