<?php

namespace Stdimitrov\Jockstream\Lib;


use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Stdimitrov\Jockstream\Config\Config;
use Stdimitrov\Jockstream\Exceptions\ServiceException;

class GuzzleClient extends AbstractLib
{
    private Client $client;

    private Config $config;

    private mixed $response;
    private string $host;

    public function __construct()
    {
        $this->client = new Client();
        $this->config = Config::getInstance();
    }

    public function setHost(string $host): static
    {
        $this->host = $host;
        return $this;
    }

    public function get(string $uri): object
    {
        try {
            $response = $this->client->get(trim($uri), [
                'headers' => [
                    'x-rapidapi-host' => $this->host,
                    'x-rapidapi-key' => $this->config->get('rapid')->apiKey
                ],
            ]);

            return (object)json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }
    }


}