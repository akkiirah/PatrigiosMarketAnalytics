<?php

namespace Repository\API;

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

    protected function requestDataMultiple(string $url, array $ids = []): array
    {
        if (!empty($ids)) {
            $idParams = [];
            foreach ($ids as $id) {
                //$idParams[] = 'id=' . urlencode($id['id']);
                $idParams[] = 'id=' . urlencode($id);
            }
            $queryString = implode('&', $idParams);

            $separator = (parse_url($url, PHP_URL_QUERY) ? '&' : '?');
            $url .= $separator . $queryString;
        }

        $proxyPool = [
            '89.116.27.24:8888', // OK
            '164.163.40.90:10000', // OK
            '164.163.42.7:10000', // OK
            // '177.234.209.82:999', // OK
            // '177.234.209.86:999', // OK
            // '177.234.209.84:999', // OK
        ];

        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, wie Gecko) Chrome/115.0.0.0 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, wie Gecko) Version/15.1 Safari/605.1.15',
            'Mozilla/5.0 (iPhone14,3; U; CPU iPhone OS 15_0 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) Version/10.0 Mobile/19A346 Safari/602.1',
            'Mozilla/5.0 (iPhone14,6; U; CPU iPhone OS 15_4 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) Version/10.0 Mobile/19E241 Safari/602.1',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.246',
            'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:15.0) Gecko/20100101 Firefox/15.0.1',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/37.0.2062.94 Chrome/37.0.2062.94 Safari/537.36',
            'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/600.8.9 (KHTML, like Gecko) Version/8.0.8 Safari/600.8.9',
            'Mozilla/5.0 (iPad; CPU OS 8_4_1 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12H321 Safari/600.1.4',
            'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.10240',
            'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_4) AppleWebKit/600.7.12 (KHTML, like Gecko) Version/8.0.7 Safari/600.7.12'
        ];

        $selectedUserAgent = $userAgents[array_rand($userAgents)];
        $selectedProxy = $proxyPool[array_rand($proxyPool)];

        // echo $selectedProxy;

        $headers = [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Language: de-DE,de;q=0.9,en-US;q=0.8,en;q=0.7',
            'Content-Type: application/json',
            "User-Agent: {$selectedUserAgent}"
        ];

        $ch = curl_init();
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2,
            // CURLOPT_PROXY => $selectedProxy,
            CURLOPT_HTTPHEADER => $headers
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

        // if (strlen($response) < 10000) {
        //     var_dump($response);
        // }

        return $decodedData ?: [];
    }
}
