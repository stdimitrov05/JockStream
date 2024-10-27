<?php

namespace Stdimitrov\Jockstream\Exceptions\HttpExceptions;

use Stdimitrov\Jockstream\Exceptions\AbstractHttpException;

/**
 * Class Http400Exception
 *
 * Exception class for Bad Request Error (400)
 *
 * @package App\Lib\Exceptions
 */
class Http400Exception extends AbstractHttpException
{
    protected ?int $httpCode = 400;
    protected ?string $httpMessage = 'Bad request';
}
