<?php

namespace Repository;

use PDO;
use PDOException;

abstract class AbstractDatabase
{
    protected $pdo;
    protected $sql;

    public function __construct()
    {
        try {
            $dbhost = 'localhost';
            $dbuser = ' ';
            $dbpass = ' ';
            $dbname = ' ';

            $this->pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
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

    protected function fetchData(string $url, array $postData = []): array
    {
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'User-Agent: BlackDesert'
            ]
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            echo $error;
        }

        curl_close($ch);

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $error = 'JSON Decode Error: ' . json_last_error_msg();
            echo $error;
        }

        return $data;
    }
}