<?php

namespace Stdimitrov\Jockstream\Lib;


use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Stdimitrov\Jockstream\Config\Config;

class GuzzleClient
{
    private Client $client;
    private array $headers;

    private Config $config;

    private mixed $response;
    private string $domainUri;

    public function __construct()
    {
        $this->client = new Client();
        $this->config = Config::getInstance();
    }

    public function instance(string $host): static
    {
        $apiKey = $this->config->get('rapid')->apiKey;

        if (!$apiKey) {
            throw new Exception('API Key is not configured');
        }

        $this->domainUri = "https://" . $host;

        $this->headers = [
            'headers' => [
                'x-rapidapi-host' => $host,
                'x-rapidapi-key' => $apiKey,
            ]
        ];

        return $this;
    }

    public function get(string $uri): static
    {
        try {
            $uri = $this->domainUri . $uri;
            $response = $this->client->get($uri, $this->headers);

            $this->response = $response->getBody()->getContents();
            return $this;
        } catch (GuzzleException $e) {
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function toObject(): object
    {
        return (object)$this->response;
    }


}