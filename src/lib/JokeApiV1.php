<?php

namespace Stdimitrov\Jockstream\Lib;

use Exception;
use Stdimitrov\Jockstream\Exceptions\ServiceException;
use Stdimitrov\Jockstream\Interfaces\JockApiV1Interface;
use Stdimitrov\Jockstream\Services\AbstractService;


class JokeApiV1 extends GuzzleClient implements JockApiV1Interface
{

    public function __construct()
    {
        parent::__construct();
    }


    public function getJoke(): array
    {
        try {
            $apiResponse = $this->get("jokes");

            if (!$apiResponse) {
                throw new ServiceException(
                    "Joke could not be retrieved from API",
                    AbstractService::ERROR_NOT_FOUND
                );
            }

            $response = [
                'id' => $apiResponse->id,
                'type' => 'single',
                'category' => $apiResponse->category,
                'data' => [
                    'joke' => $apiResponse->joke
                ]
            ];
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }


}