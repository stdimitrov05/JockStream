<?php

namespace Stdimitrov\Jockstream\Lib;

use Exception;
use Stdimitrov\Jockstream\Exceptions\ServiceException;
use Stdimitrov\Jockstream\Interfaces\JockApiV2Interface;


class JokeApiV2 extends GuzzleClient implements JockApiV2Interface
{

    public function __construct()
    {
        parent::__construct();
    }


    public function getJoke(): array
    {
        try {
            $randomId = random_int(0, 150);
            $uri = "joke/Any?format=json&idRange=$randomId";
            $apiResponse = $this->get($uri);

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

        } catch (Exception $e) {
            throw new ServiceException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }


}