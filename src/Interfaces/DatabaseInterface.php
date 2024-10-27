<?php

namespace Stdimitrov\Jockstream\Interfaces;

interface DatabaseInterface
{
    /**
     * Executes a query and fetches all results as an object with camelCase keys.
     *
     * @param string $query
     * @param array|null $params
     * @return object
     */
    public function fetchAll(string $query, ?array $params = []): object;

    /**
     * Executes a query and fetches one result as an object with camelCase keys.
     *
     * @param string $query
     * @param array|null $params
     * @return object
     */
    public function fetchOne(string $query, ?array $params = []): object;

    /**
     * Executes a query and fetches the first column from the first row of the result set.
     *
     * @param string $query
     * @param array|null $params
     * @return mixed
     */
    public function fetchColumn(string $query, ?array $params = []): mixed;

    /**
     * Executes an SQL update statement with optional parameters.
     *
     * @param string $sql
     * @param array $params
     * @return void
     */
    public function update(string $sql, array $params = []): void;
}