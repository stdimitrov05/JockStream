<?php

namespace Stdimitrov\Jockstream\Services;

use PDO;
use Stdimitrov\Jockstream\Config\Injectable;
use Stdimitrov\Jockstream\JockStream;
use Stdimitrov\Jockstream\Models\ApiJokeProviders;

abstract class AbstractService extends Injectable
{
    const int ERROR_NOT_FOUND = 14000;
    const int ERROR_TOO_MANY_REQUESTS = 14010;
    const int ERROR_BAD_REQUEST = 14020;

    /**
     * Retrieves the LogsServices instance for logging operations.
     * @return LogsServices The logging service instance.
     */
    public function logger(): LogsServices
    {
        return $this->getService('logsServices');
    }

}