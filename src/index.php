<?php

namespace Stdimitrov\Jockstream;

use Exception;
use Stdimitrov\Jockstream\Config\Config;
use Stdimitrov\Jockstream\Lib\Database;

require_once "../vendor/autoload.php"; // Ensure your autoload is correct
require_once "Config/di.php"; // Include the DI configuration
require_once "Lib/Database.php"; // Include the DI configuration

class Jockstream {

    private Config $config;
    private Database $db;

    public function __construct() {
        $this->config = Config::getInstance();
        $this->db = new Database();
    }

    public function listRandomJock(): array
    {
       echo "test";
    }
}

$app = new Jockstream();
$app->listRandomJock();
