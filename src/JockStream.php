<?php

namespace Stdimitrov\Jockstream;

use Exception;
use Stdimitrov\Jockstream\Config\Injectable;
use Stdimitrov\Jockstream\Exceptions\HttpExceptions\Http400Exception;
use Stdimitrov\Jockstream\Exceptions\ServiceException;

/**
 * Class JockStream
 *
 * The JockStream class provides access to joke retrieval methods, including fetching
 * a single joke or multiple jokes through the JockStreamController service.
 *
 * @package Stdimitrov\Jockstream
 */
class JockStream extends Injectable
{
    /**
     * Retrieves a single joke.
     *
     * This method fetches a single joke using the JockStreamController service.
     *
     * @return array The joke data in a formatted array.
     * @throws ServiceException|Exception If no joke is found or an error occurs in the service.
     */
    public function listSingleJoke(): array
    {
        return $this->getService('jockStreamController')->fetchJoke();
    }

    /**
     * Retrieves multiple jokes based on the specified limit.
     *
     * This method fetches multiple jokes using the JockStreamController service.
     * The number of jokes retrieved is determined by the provided limit parameter.
     *
     * @param int $limit The number of jokes to retrieve.
     * @return array An array of formatted joke entries.
     * @throws ServiceException If no jokes are found or an error occurs in the service.
     * @throws Http400Exception|Exception If the limit is not a positive integer.
     */
    public function listMultipleJokes(int $limit): array
    {
        return $this->getService('jockStreamController')->listMultipleJokes($limit);
    }
}
