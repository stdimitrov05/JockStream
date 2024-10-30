<?php

namespace Stdimitrov\Jockstream\Config;

use Phalcon\Di\Di;

class Injectable
{

    /**
     * @throws \Exception
     */
    public function getService(string $name)
    {
        // Ensure the DI container is correctly loaded
        $di = require __DIR__. '/../config/di.php';

        return $di->get($name);
    }
}