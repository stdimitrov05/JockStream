<?php


use Stdimitrov\Jockstream\Lib\Database;

function getPdoInstance(object $config): PDO
{
    $connection = new Database();
    return $connection->getConnection();
}
