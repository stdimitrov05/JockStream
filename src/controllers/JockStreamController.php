<?php

namespace Stdimitrov\Jockstream\Controllers;

use Stdimitrov\Jockstream\Exceptions\HttpExceptions\Http404Exception;
use Stdimitrov\Jockstream\Exceptions\HttpExceptions\Http429Exception;
use Stdimitrov\Jockstream\Exceptions\HttpExceptions\Http500Exception;
use Stdimitrov\Jockstream\Exceptions\ServiceException;
use Stdimitrov\Jockstream\Services\AbstractService;

class JockStreamController
{
    private object $jokeService;

    public function __construct()
    {
        // Ensure the DI container is correctly loaded
        $di = require __DIR__. '/../config/di.php';

        $this->jokeService = $di->get('jokeServices');
    }

    public function fetchJoke(): array
    {
        try {
            $response = $this->jokeService->getJokeFromAvailableProvider();

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
}