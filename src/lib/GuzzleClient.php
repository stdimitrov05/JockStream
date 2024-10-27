<?php

namespace Stdimitrov\Jockstream\Lib;

use Exception;
use GuzzleHttp\Client;
use Stdimitrov\Jockstream\Config\Config;
use GuzzleHttp\Exception\RequestException;
use Stdimitrov\Jockstream\Interfaces\GuzzleClientInterface;

class GuzzleClient implements GuzzleClientInterface
{
    private Client $client;
    private Config $config;
    private string $host;
    private string $api;

    public function __construct()
    {
        $this->client = new Client();
        $this->config = Config::getInstance();
    }

    /**
     * Set the host for the API request.
     *
     * @param string $host
     * @return $this
     */
    public function setHost(string $host): static
    {
        $this->host = $host;
        return $this;
    }

    /**
     * Set the API endpoint (URI).
     *
     * @param string $uri
     * @return $this
     */
    public function setApiEndpoint(string $uri): static
    {
        $this->api = $uri;
        return $this;
    }

    /**
     * Make a GET request to the API.
     *
     * @param string $uri
     * @return object
     * @throws Exception
     */
    public function get(string $uri): object
    {
        $fullUri = $this->api . $uri;
        try {
            $promise = $this->client->getAsync(trim($fullUri), [
                'headers' => [
                    'x-rapidapi-host' => $this->host,
                    'x-rapidapi-key' => $this->config->get('rapid')->apiKey,
                    'Accept' => 'application/json'
                ],
                'connect_timeout' => 5.0, // Set connection timeout
                'timeout' => 10.0, // Set total request timeout
                'verify' => false, // Disable SSL verification (trusted environments)
            ]);

            // Wait for the promise to resolve and process the response
            return $promise->then(function ($response) {
                $body = $response->getBody()->getContents();
                return (object)json_decode($body, true);
            })->wait();

        } catch (RequestException $e) {
            // Catch Guzzle-specific exceptions and add more context
            throw new Exception("API Request to $fullUri failed: " . $e->getMessage(), $e->getCode(), $e);
        } catch (Exception $e) {
            // Handle general exceptions
            throw new Exception("Unexpected error during API call: " . $e->getMessage(), $e->getCode(), $e);
        }
    }
}