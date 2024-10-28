<?php

namespace Stdimitrov\Jockstream\Exceptions\HttpExceptions;

use Stdimitrov\Jockstream\Exceptions\AbstractHttpException;

/**
 * Class Http429Exception
 *
 * Exception class for Too many requests Error (429)
 *
 * @package App\Lib\Exceptions
 */
class Http429Exception extends AbstractHttpException
{
    protected ?int $httpCode = 429;
    protected ?string $httpMessage = 'Too many requests';
}
