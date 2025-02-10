<?php

namespace Repository;

use PDO;
use PDOException;

abstract class AbstractApiRepository
{
    protected $pdo;
    protected $sql;

    public function __construct()
    {
        // try {
        //     $dbhost = 'localhost';
        //     $dbuser = 'root';
        //     $dbpass = '';
        //     $dbname = 'mysql';
        // 
        //     $this->pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        //     $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // 
        // } catch (PDOException $ex) {
        //     echo $ex->getMessage();
        // }
    }

    public function query(string $parameter, array $params = []): ?array
    {
        $this->sql = $parameter;
        $stmt = $this->pdo->prepare($this->sql);

        if ($params) {
            foreach ($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
        }

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row : null;
    }
    public function queryAll(string $parameter, array $params = []): ?array
    {
        $this->sql = $parameter;
        $stmt = $this->pdo->prepare($this->sql);

        if ($params) {
            foreach ($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
        }

        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rows ?: null;
    }
    public function insert(string $parameter, array $params = []): ?int
    {
        $this->sql = $parameter;
        $stmt = $this->pdo->prepare($this->sql);

        if ($params) {
            foreach ($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
        }

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $this->pdo->lastInsertId();
        }

        return null;
    }

    public function fetchDataPost(string $url, array $postData = []): array
    {
        return $this->requestData($url, $postData, 'POST');
    }

    public function fetchDataGet(string $url, array $getData = []): array
    {
        return $this->requestData($url, $getData, 'GET');
    }

    protected function requestData(string $url, array $data = [], string $method = 'GET'): array
    {
        $ch = curl_init();

        // Basis-CURL-Optionen
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

        // GET-Anfrage: Falls Daten vorhanden sind, als Query-String anhängen
        if (strtoupper($method) === 'GET' && !empty($data)) {
            $queryString = http_build_query($data);
            // Prüfen, ob die URL bereits Parameter enthält
            $separator = (strpos($url, '?') === false) ? '?' : '&';
            $options[CURLOPT_URL] .= $separator . $queryString;
        }

        // POST-Anfrage: Optionen setzen
        if (strtoupper($method) === 'POST') {
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_CUSTOMREQUEST] = 'POST';
            $options[CURLOPT_POSTFIELDS] = json_encode($data);
        }

        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);

        // Fehlerbehandlung bei cURL-Fehlern
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