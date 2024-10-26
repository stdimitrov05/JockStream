<?php


use Stdimitrov\Jockstream\Lib\Database;

function getPdoInstance(): PDO
{
    $connection = new Database();
    return $connection->getConnection();
}
