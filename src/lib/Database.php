<?php

namespace Stdimitrov\Jockstream\Lib;

use PDO;
use PDOException;
use PDOStatement;
use Stdimitrov\Jockstream\Config\Config;
use Stdimitrov\Jockstream\Interfaces\DatabaseInterface;

class Database implements DatabaseInterface
{
    private PDO $pdo;

    public function __construct()
    {
        $config = Config::getInstance()->get('db');
        try {
            $this->pdo = new PDO(
                "mysql:host=$config->host;dbname=$config->dbname",
                $config->username,
                $config->password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     *  Executes a query and fetches all results as an object with camelCase keys.
     * @param string $query
     * @param array|null $params
     * @return object
     */
    public function fetchAll(string $query, ?array $params = []): object
    {
        $stmt = $this->pdo->prepare($query);
        $stmt = $this->setStatementParams($stmt, $query, $params);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($results)) return (object)[];

        return (object)Helper::snakeToCamelArray($results);
    }

    /**
     *  Executes a query and fetches one result as an object with camelCase keys.
     * @param string $query
     * @param array|null $params
     * @return object
     */
    public function fetchOne(string $query, ?array $params = []): object
    {
        $stmt = $this->pdo->prepare($query);
        $stmt = $this->setStatementParams($stmt, $query, $params);
        $stmt->execute();

        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($results)) return (object)[];

        return (object)Helper::snakeToCamelArray($results);
    }

    /**
     * Executes a query and fetches the first column from the first row of the result set.
     *
     * @param string $query
     * @param array|null $params
     * @return mixed
     */
    public function fetchColumn(string $query, ?array $params = []): mixed
    {
        $stmt = $this->pdo->prepare($query);
        $stmt = $this->setStatementParams($stmt, $query, $params);
        $stmt->execute();

        $results = $stmt->fetchColumn();

        if (empty($results)) return null;

        return $results;
    }

    /**
     * Executes an SQL update statement with optional parameters.
     * @param string $sql
     * @param array $params
     * @return void
     */
    public function update(string $sql, array $params = []): void
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt = $this->setStatementParams($stmt, $sql, $params);
        $stmt->execute();
    }

    /**
     * Binds parameters to a prepared SQL statement based on the provided query and parameters.
     * @param PDOStatement $stmt
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */
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
        var_dump($bindValues);

        return $stmt;
    }

    public function insert(string $sql, array $params = []): void {
        $stmt = $this->pdo->prepare($sql);
        $stmt = $this->setStatementParams($stmt, $sql, $params);
        $stmt->execute();
    }
}