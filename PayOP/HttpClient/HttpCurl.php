<?php

namespace PayOp\HttpClient;

use http\Exception\RuntimeException;

class HttpCurl
{
    /**
     * @var array
     */
    private $options = [
        CURLOPT_CONNECTTIMEOUT => 60,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HEADER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_SSL_VERIFYPEER => 1,
        CURLOPT_TIMEOUT => 60,
    ];

    /**
     * @param string $method
     * @param string $url
     * @param array $headers
     * @param array $data
     * @return Response
     */
    public function request(string $method, string $url, array $headers, array $data  = []): Response
    {
        $method = strtoupper($method);

        if (!$url) {
            throw new RuntimeException('The url is empty.');
        }

        $ch = curl_init($url);
        foreach ($this->options as $option => $value) {
            curl_setopt($ch, $option, $value);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        $response = curl_exec($ch);
        if ($response === false) {
            $response = curl_error($ch);
        }
        $httpStatus = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);
        return new Response($httpStatus, $response);
    }
}
