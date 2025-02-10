<?php

namespace Repository;

use PDO;
use PDOException;

abstract class AbstractLocalRepository
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
}