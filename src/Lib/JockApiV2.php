<?php

namespace Stdimitrov\Jockstream\Lib;

use Stdimitrov\Jockstream\Exceptions\ServiceException;
use Stdimitrov\Jockstream\Interfaces\JockApiV2Interface;


class JockApiV2 extends GuzzleClient implements JockApiV2Interface
{
    private Database $db;
    private object $provider;
    const int PROVIDER_ID = 1;

    public function __construct()
    {
        parent::__construct();
        $this->db = new Database();

        $this->initData();
    }

    public function getJoke(): array
    {
        try {
            $uri = $this->provider->apiUri . "joke/Any?format=json";
            $apiResponse = $this->setHost($this->provider->host)->get($uri);

            $response = [
                'id' => $apiResponse->id,
                'type' => $apiResponse->type,
                'category' => $apiResponse->category,
            ];

            if ($apiResponse->type == 'twopart') {
                $response['data'] = [
                    'question' => $apiResponse->setup,
                    'delivery' => $apiResponse->delivery
                ];
            } else {
                $response['data'] = [
                    'joke' => $apiResponse->joke,
                ];
            }

        } catch (\Exception $e) {
            throw new ServiceException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }


    private function initData(): void
    {
        $sql = "
            SELECT 
                id, host, api_uri
            FROM api_joke_providers 
            WHERE is_activated = 1 AND id = " . self::PROVIDER_ID . "
            LIMIT 1
        ";
        $providerDetails = $this->db->fetchOne($sql);

        if (empty($providerDetails)) {
            throw new ServiceException(
                'No jock provider found for id ' . self::PROVIDER_ID,
                self::ERROR_NOT_FOUND
            );
        }

        $this->provider = $providerDetails;
    }
}