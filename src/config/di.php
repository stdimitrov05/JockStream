<?php

namespace Stdimitrov\Jockstream\Config;

use Stdimitrov\Jockstream\Controllers\JockStreamController;
use Stdimitrov\Jockstream\Lib\Database;
use Stdimitrov\Jockstream\Lib\GuzzleClient;
use Stdimitrov\Jockstream\Services\JokeServices;
use Stdimitrov\Jockstream\Services\LogsServices;

$di = new Container();

$di->set('jokeServices', function () {
    return new JokeServices();
});

$di->set('logsServices', function () {
    return new LogsServices();
});

$di->set('jockStreamController', function () {
    return new JockStreamController();
});

$di->set('config', function () {
    return new Config();
});

$di->set('db', function () {
    return new Database();
});

$di->set('guzzleClient', function () {
    return new GuzzleClient();
});

return $di;