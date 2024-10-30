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

    /**
     * Retrieves a single joke from the API and formats the response.
     *
     * @return array The formatted joke data, including ID, type, category, and joke text.
     * @throws ServiceException If the joke could not be retrieved or an API error occurs.
     */
    public function getJoke(): array
    {
        try {
            $apiResponse = $this->get("jokes");
            if (empty((array)$apiResponse)) {
                throw new ServiceException(
                    "Joke could not be retrieved from API",
                    AbstractService::ERROR_NOT_FOUND
                );
            } else {
                $response = [
                    'id' => $apiResponse->id,
                    'type' => 'single',
                    'category' => $apiResponse->category,
                    'data' => [
                        'joke' => $apiResponse->joke
                    ]
                ];
            }
        } catch (ServiceException|Exception $e) {
            throw new ServiceException($e->getMessage(), $e->getCode());
        }

        return $response;
    }


}