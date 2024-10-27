<?php

namespace Stdimitrov\Jockstream\Config;

class Config
{
    private static ?Config $instance = null;
    private mixed $settings;

    public function __construct()
    {
        $this->settings = [
            'db' => [
                'adapter' => getenv('DB_ADAPTER'),
                'charset' => getenv('DB_CHARSET'),
                'collation' => getenv('DB_COLLATION'),
                'dbname' => getenv('DB_NAME'),
                'host' => getenv('DB_HOST'),
                'password' => getenv('DB_PASSWORD'),
                'port' => getenv('DB_PORT'),
                'username' => getenv('DB_USERNAME'),
            ],
            'rapid' => [
                'apiKey' => getenv('RAPID_API_KEY'),
            ]
        ];
    }

    public static function getInstance(): ?Config
    {
        if (self::$instance === null) {
            self::$instance = new Config();
        }
        return self::$instance;
    }

    public function get($key): ?object
    {
        return (object)$this->settings[$key] ?? null;
    }
}