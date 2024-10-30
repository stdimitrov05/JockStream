<?php

namespace Stdimitrov\Jockstream\Controllers;

use Exception;
use Stdimitrov\Jockstream\Config\Injectable;
use Stdimitrov\Jockstream\Exceptions\HttpExceptions\Http400Exception;
use Stdimitrov\Jockstream\Exceptions\HttpExceptions\Http404Exception;
use Stdimitrov\Jockstream\Exceptions\HttpExceptions\Http429Exception;
use Stdimitrov\Jockstream\Exceptions\HttpExceptions\Http500Exception;
use Stdimitrov\Jockstream\Exceptions\ServiceException;
use Stdimitrov\Jockstream\Services\AbstractService;

class JockStreamController extends Injectable
{
    /**
     * Retrieves a random joke from the joke service.
     * @return array The response containing the joke details.
     * @throws Http404Exception If no joke is found.
     * @throws Http429Exception If too many requests are made.
     * @throws Http500Exception|Exception For any other server-related issues.
     */
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

    /**
     * Retrieves a specified number of random jokes from the joke service.
     *
     * @param int $limit The number of jokes to retrieve; must be a positive integer.
     * @return array An array of responses containing joke details.
     * @throws Http400Exception If the limit is not a positive integer.
     * @throws Http404Exception If no jokes are found.
     * @throws Http500Exception|Exception For any other server-related issues.
     */
    public function listMultipleJokes(int $limit): array
    {
        if (!is_numeric($limit) || $limit < 0) {
            throw new Http400Exception(
                'Limit must be a positive integer',
                AbstractService::ERROR_BAD_REQUEST
            );
        }

        try {
            $response = $this->getService('jokeServices')->fetchMultipleRandomJokes($limit);

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