<?php

namespace Stdimitrov\Jockstream\Interfaces;

use Exception;

interface GuzzleClientInterface
{
    /**
     * Set the host for the API request.
     *
     * @param string $host
     * @return static
     */
    public function setHost(string $host): static;

    /**
     * Set the API endpoint (URI).
     *
     * @param string $uri
     * @return static
     */
    public function setApiEndpoint(string $uri): static;

    /**
     * Make a GET request to the API.
     *
     * @param string $uri
     * @return object
     * @throws Exception
     */
    public function get(string $uri): object;
}