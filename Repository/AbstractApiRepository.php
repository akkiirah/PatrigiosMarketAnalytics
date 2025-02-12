<?php

namespace Repository;

abstract class AbstractApiRepository
{
    public function fetchData(string $url, array $getData = []): array
    {
        if (!empty($getData)) {
            $queryString = http_build_query($getData);
            $separator = (strpos($url, '?') === false) ? '?' : '&';
            $url .= $separator . $queryString;
        }

        return $this->requestData($url);
    }

    protected function requestData(string $url): array
    {
        $ch = curl_init();

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 17_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/133.0.6943.33 Mobile/15E148 Safari/604.1'
            ]
        ];

        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            echo $error;
            return [];
        }

        curl_close($ch);

        $decodedData = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo 'JSON Decode Error: ' . json_last_error_msg();
        }

        return $decodedData ?: [];
    }
}
