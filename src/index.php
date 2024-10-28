<?php

use Stdimitrov\Jockstream\Exceptions\ServiceException;
use Stdimitrov\Jockstream\JockStream;

require_once '../vendor/autoload.php';

try {

    $jokeClass = new JockStream();

    $response  = $jokeClass->listSingleJoke();

    print_r($response);die;
} catch (ServiceException | Exception $e) {
    echo $e->getMessage();
}
