<?php

use Stdimitrov\Jockstream\Exceptions\ServiceException;
use Stdimitrov\Jockstream\JockStream;

require_once '../vendor/autoload.php';

try {

    $jokeClass = new JockStream();

    $response  = $jokeClass->listMultipleJokes(3);

    print_r($response);die;
} catch (ServiceException | Exception $e) {
    echo $e->getMessage();die;
}
