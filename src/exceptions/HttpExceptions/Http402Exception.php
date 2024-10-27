<?php

namespace Stdimitrov\Jockstream\Exceptions\HttpExceptions;

use Stdimitrov\Jockstream\Exceptions\AbstractHttpException;

/**
 * Class Http401Exception
 *
 * Exception class for Payment Required Error (402)
 *
 * @package App\Lib\Exceptions
 */
class Http402Exception extends AbstractHttpException
{
    protected ?int $httpCode = 402;
    protected ?string $httpMessage = 'Payment Required';
}
