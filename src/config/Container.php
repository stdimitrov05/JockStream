<?php

namespace Stdimitrov\Jockstream\Config;

use Exception;

class Container
{
    // Stores the registered services
    protected array $services = [];

    /**
     * Register a service with a closure (factory)
     * @param string $name
     * @param callable $callable
     * @return void
     */
    public function set(string $name, callable $callable): void
    {
        $this->services[$name] = $callable;
    }


    /**
     * Retrieve the service, create it if necessary
     * @param string $name
     * @return mixed
     * @throws Exception
     */
    public function get(string $name): mixed
    {
        if (!isset($this->services[$name])) {
            throw new Exception("Service not found: {$name}");
        }

        // Call the service factory to create the object
        return $this->services[$name]($this);
    }
}