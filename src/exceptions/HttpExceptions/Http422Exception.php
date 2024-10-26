<?php

namespace Stdimitrov\Jockstream\Exceptions\HttpExceptions;

use Stdimitrov\Jockstream\Exceptions\AbstractHttpException;

/**
 * Class Http422Exception
 *
 * Exception class for Unprocessable entity Error (422)
 *
 * @package App\Lib\Exceptions
 */
class Http422Exception extends AbstractHttpException
{
    protected ?int $httpCode = 422;
    protected ?string $httpMessage = 'Unprocessable entity';
}
