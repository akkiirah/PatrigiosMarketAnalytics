<?php

namespace Repository\Local;

use PDO;
use PDOException;

abstract class AbstractLocalRepository
{
    protected ?PDO $pdo = null;
    protected string $sql = '';

    public function __construct()
    {
        // DDEV
        // try {
        //     $dbhost = 'db';
        //     $dbuser = 'root';
        //     $dbpass = 'root';
        //     $dbname = 'db';
        // 
        //     $this->pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        //     $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // 
        // } catch (PDOException $ex) {
        //     echo $ex->getMessage();
        // }

        // XAMPP
        try {
            $dbhost = 'localhost';
            $dbuser = 'root';
            $dbpass = '';
            $dbname = 'db';

            $this->pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    protected function executeStatement(string $sql, array $params = []): \PDOStatement
    {
        $this->sql = $sql;
        $stmt = $this->pdo->prepare($this->sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function query(string $sql, array $params = []): ?array
    {
        $stmt = $this->executeStatement($sql, $params);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function queryAll(string $sql, array $params = []): ?array
    {
        $stmt = $this->executeStatement($sql, $params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows ?: null;
    }

    public function insert(string $sql, array $params = []): ?int
    {
        $stmt = $this->executeStatement($sql, $params);
        if ($stmt->rowCount() > 0) {
            return (int) $this->pdo->lastInsertId();
        }
        return null;
    }

    public function update(string $sql, array $params = []): int
    {
        $stmt = $this->executeStatement($sql, $params);
        return $stmt->rowCount();
    }

    public function delete(string $sql, array $params = []): int
    {
        $stmt = $this->executeStatement($sql, $params);
        return $stmt->rowCount();
    }
}