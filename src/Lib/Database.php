<?php

namespace Stdimitrov\Jockstream\Lib;

use PDO;
use PDOException;
use PDOStatement;
use Stdimitrov\Jockstream\Config\Config;

class Database
{
    private PDO $pdo;

    public function __construct()
    {
        $config = Config::getInstance()->get('db'); // Adjust the path if necessary
        try {
            $this->pdo = new PDO(
                "mysql:host={$config->host};dbname={$config->dbname}",
                $config->username,
                $config->password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    public function fetchAll(string $query, ?array $params): object
    {
        $stmt = $this->pdo->prepare($query);
        $stmt = $this->setStatementParams($stmt, $query, $params);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($results)) return (object)[];

        return (object)Helper::snakeToCamelArray($results);
    }

    private function setStatementParams(PDOStatement $stmt, string $query, array $params): PDOStatement
    {
        $bindValues = [];
        $queryParams = Helper::extractPlaceholders($query);

        if (empty($queryParams) || empty($params)) return $stmt;

        foreach ($queryParams as $index) {
            $bindValues[$index] = $params[$index];
        }

        // Bind parameters dynamically
        foreach ($bindValues as $index => $value) {
            if (is_numeric($value)) {
                $stmt->bindValue($index + 1, $value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($index + 1, $value);
            }
        }

        return $stmt;
    }
}