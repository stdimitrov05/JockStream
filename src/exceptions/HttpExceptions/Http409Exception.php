<?php

namespace Stdimitrov\Jockstream\Exceptions\HttpExceptions;

use Stdimitrov\Jockstream\Exceptions\AbstractHttpException;

/**
 * Class Http409Exception
 *
 * Exception class for Conflict Error (409)
 *
 * @package App\Lib\Exceptions
 */
class Http409Exception extends AbstractHttpException
{
    protected ?int $httpCode = 409;
    protected ?string $httpMessage = 'Conflict';
}
