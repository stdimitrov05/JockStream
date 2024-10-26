<?php

namespace Stdimitrov\Jockstream;

use Exception;
use Stdimitrov\Jockstream\Config\Config;
use Stdimitrov\Jockstream\Lib\Database;
use Stdimitrov\Jockstream\Lib\GuzzleClient;
use Stdimitrov\Jockstream\Lib\Helper;
use Stdimitrov\Jockstream\Lib\JockApiV2;

require_once "../vendor/autoload.php"; // Ensure your autoload is correct
require_once "Config/di.php"; // Include the DI configuration
require_once "Lib/Database.php"; // Include the DI configuration

class Jockstream
{
    private Config $config;
    private Database $db;
    private object $provider;
    private GuzzleClient $guzzleClient;

    public function listJoke(): object
    {
        try {
            $jokeApi = new JockApiV2();
            $response = $jokeApi->getJoke();

        } catch (Exception $e) {
            echo $e->getCode();
            echo $e->getMessage();
        }

        return Helper::arrayToObject($response);
    }


}

$app = new Jockstream();
print_r($app->listJoke());