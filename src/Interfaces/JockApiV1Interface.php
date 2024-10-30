<?php

namespace Stdimitrov\Jockstream\Interfaces;

use Stdimitrov\Jockstream\Exceptions\ServiceException;

interface JockApiV1Interface {
    public function __construct();

    /**
     * Retrieves a single joke from the API and formats the response.
     *
     * @return array The formatted joke data, including ID, type, category, and joke text.
     * @throws ServiceException If the joke could not be retrieved or an API error occurs.
     */
    public function getJoke(): array;
}
