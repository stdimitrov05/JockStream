<?php

namespace Stdimitrov\Jockstream\Lib;

use Exception;
use Stdimitrov\Jockstream\Exceptions\ServiceException;
use Stdimitrov\Jockstream\Interfaces\JockApiV1Interface;
use Stdimitrov\Jockstream\Services\AbstractService;


class JokeAlways extends GuzzleClient implements JockApiV1Interface
{

    public function __construct()
    {
        parent::__construct();
    }


    public function getJoke(): array
    {
        try {
            $apiResponse = $this->get("common");

            if (Helper::isObjectEmpty($apiResponse)) {
                throw new ServiceException(
                    "Joke could not be retrieved from API",
                    AbstractService::ERROR_NOT_FOUND
                );
            }

            $response = [
                'id' => time(),
                'type' => 'single',
                'category' => 'random',
                'data' => [
                    'joke' => $apiResponse->data
                ]
            ];
        } catch (ServiceException|Exception $e) {
            throw new ServiceException($e->getMessage(), $e->getCode());
        }

        return $response;
    }


}