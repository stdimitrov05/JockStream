<?php

use Stdimitrov\Jockstream\Exceptions\HttpExceptions\Http500Exception;
use Stdimitrov\Jockstream\Exceptions\HttpExceptions\Http404Exception;
use Stdimitrov\Jockstream\Exceptions\ServiceException;
use Stdimitrov\Jockstream\Services\AbstractService;

require_once "../vendor/autoload.php"; // Ensure your autoload is correct
$di = require 'config/di.php'; // Ensure the DI container is correctly loaded

class Jockstream
{
    private object $jokeService;  // Added property for joke service

    public function __construct($di)
    {
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
                default => new Http500Exception('Internal Server Error', $e->getCode(), $e),
            };
        }

        return $response;
    }
}

// Instantiate Jockstream with DI container
$app = new Jockstream($di);
print_r($app->listJoke());  // Print the result of listJoke
