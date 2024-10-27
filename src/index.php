<?php

use Stdimitrov\Jockstream\Exceptions\HttpExceptions\Http500Exception;
use Stdimitrov\Jockstream\Exceptions\HttpExceptions\Http404Exception;
use Stdimitrov\Jockstream\Exceptions\ServiceException;
use Stdimitrov\Jockstream\Services\AbstractService;

require_once "../vendor/autoload.php"; // Ensure your autoload is correct

class Jockstream
{
    private object $jokeService;  // Added property for joke service

    public function __construct()
    {
        // Ensure the DI container is correctly loaded
        $di = require 'config/di.php';

        $this->jokeService = $di->get('jokeServices');
    }

    public function listJoke(): array
    {
        try {
            $response = $this->jokeService->getJoke();
        } catch (ServiceException $e) {
            $response = match ($e->getCode()) {
                AbstractService::ERROR_NOT_FOUND
                => [
                    'status' => 'error',
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ],
                default => [
                    'status' => 'Internal Server Error',
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ]
            };
        }

        return $response;
    }
}

// Instantiate Jockstream with DI container
$app = new Jockstream();
print_r($app->listJoke());  // Print the result of listJoke
