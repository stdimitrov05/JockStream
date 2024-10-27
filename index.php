<?php


use Stdimitrov\Jockstream\Exceptions\HttpExceptions\Http404Exception;
use Stdimitrov\Jockstream\Exceptions\HttpExceptions\Http500Exception;
use Stdimitrov\Jockstream\Exceptions\ServiceException;
use Stdimitrov\Jockstream\Services\AbstractService;

require_once "vendor/autoload.php"; // Ensure your autoload is correct

class Jockstream
{
    private object $jokeService;

    public function __construct()
    {
        // Ensure the DI container is correctly loaded
        $di = require './src/config/di.php';

        $this->jokeService = $di->get('jokeServices');
    }

    public function listJoke(): array
    {
        try {
            $response = $this->jokeService->getJoke();
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

