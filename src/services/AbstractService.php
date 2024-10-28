<?php

namespace Stdimitrov\Jockstream\Services;

use PDO;
use Stdimitrov\Jockstream\Models\ApiJokeProviders;

abstract class AbstractService
{
    const int ERROR_NOT_FOUND = 14000;
    const int ERROR_TOO_MANY_REQUESTS = 14010;

}