<?php

namespace Stdimitrov\Jockstream;

class JockStream
{
    private object $jokeController;

    public function __construct()
    {
        // Ensure the DI container is correctly loaded
        $di = require __DIR__. '/config/di.php';

        $this->jokeController = $di->get('jockStreamController');
    }

    public function listSingleJoke(): array
    {
        return $this->jokeController->fetchJoke();
    }

}