<?php

namespace Stdimitrov\Jockstream\Controllers;

use Stdimitrov\Jockstream\Config\Injectable;
use Stdimitrov\Jockstream\Exceptions\HttpExceptions\Http404Exception;
use Stdimitrov\Jockstream\Exceptions\HttpExceptions\Http429Exception;
use Stdimitrov\Jockstream\Exceptions\HttpExceptions\Http500Exception;
use Stdimitrov\Jockstream\Exceptions\ServiceException;
use Stdimitrov\Jockstream\Services\AbstractService;

class JockStreamController extends Injectable
{

    public function fetchJoke(): array
    {
        try {
            $response = $this->getService('jokeServices')->getRandomJoke();

        } catch (ServiceException $e) {

            throw match ($e->getCode()) {
                AbstractService::ERROR_NOT_FOUND
                => new Http404Exception($e->getMessage(), $e->getCode(), $e),
                AbstractService::ERROR_TOO_MANY_REQUESTS
                => new Http429Exception($e->getMessage(), $e->getCode(), $e),
                default => new Http500Exception($e->getMessage(), $e->getCode(), $e),
            };
        }

        return $response;
    }

    public function listMultipleJokes(): array
    {
        try {
            $response = $this->getService('jokeServices')->getRandomMultipleJokes();

        } catch (ServiceException $e) {

            throw match ($e->getCode()) {
                AbstractService::ERROR_NOT_FOUND
                => new Http404Exception($e->getMessage(), $e->getCode(), $e),
                default => new Http500Exception($e->getMessage(), $e->getCode(), $e),
            };
        }

        return $response;
    }
}