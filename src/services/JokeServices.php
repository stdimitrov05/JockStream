<?php

namespace Stdimitrov\Jockstream\Services;

use Stdimitrov\Jockstream\Exceptions\ServiceException;
use Stdimitrov\Jockstream\Interfaces\JockApiV2Interface;
use Stdimitrov\Jockstream\Lib\JokeApiV2;
use Stdimitrov\Jockstream\Models\ApiJokeProviders;

class JokeServices extends AbstractService
{
    const int JOKE_API_V2 = 1;
    const int JOKE_API_V1 = 2;
    const int WORLD_OF_JOKES1 = 3;

    private JockApiV2Interface $clientInstance;

    /**
     * Fetches a joke from an available joke provider.
     *
     * @return array
     * @throws ServiceException
     */
    public function getJoke(): array
    {
        $apiProvider = new ApiJokeProviders();
        $availableProvider = $apiProvider->findAvailableProvider();

        if (!$availableProvider) {
            throw new ServiceException(
                "No joke providers found",
                self::ERROR_NOT_FOUND
            );
        }

        // Initialize the correct client for the available provider
        $this->initializeClientForProvider($apiProvider->getId());

        $response = $this->clientInstance
            ->setHost($apiProvider->getHost())
            ->setApiEndpoint($apiProvider->getApiUri())
            ->getJoke();

        $apiProvider->updateUsedTotal();

        return $response;
    }

    /**
     * Initializes the appropriate API client based on the provider ID.
     *
     * @param int $providerId
     * @return void
     * @throws ServiceException
     */
    private function initializeClientForProvider(int $providerId): void
    {
        switch ($providerId) {
            case self::JOKE_API_V2:
                $this->clientInstance = new JokeApiV2();
                break;
            case self::JOKE_API_V1:
                // You would instantiate JokeApiV1 here (when available)
                // $this->clientInstance = new JokeApiV1();
                throw new ServiceException("JOKE_API_V1 is not yet implemented.");
            case self::WORLD_OF_JOKES1:
                // You would instantiate WorldOfJokes1 here (when available)
                // $this->clientInstance = new WorldOfJokes1();
                throw new ServiceException("WORLD_OF_JOKES1 is not yet implemented.");
            default:
                throw new ServiceException("Unsupported provider ID: $providerId");
        }
    }
}
