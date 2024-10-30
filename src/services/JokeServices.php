<?php

namespace Stdimitrov\Jockstream\Services;

use Stdimitrov\Jockstream\Exceptions\ServiceException;
use Stdimitrov\Jockstream\Interfaces\JockApiV2Interface;
use Stdimitrov\Jockstream\Lib\JokeAlways;
use Stdimitrov\Jockstream\Lib\JokeApiV1;
use Stdimitrov\Jockstream\Lib\JokeApiV2;
use Stdimitrov\Jockstream\Models\ApiJokeProviders;

class JokeServices extends AbstractService
{
    const int JOKE_API_V2 = 1;
    const int JOKE_API_V1 = 2;
    const int JOKE_ALWAYS = 3;

    private mixed $apiJokeProvider = null;


    private JockApiV2Interface | JokeApiV1 | JokeAlways $clientInstance;

    /**
     * Fetches a joke from an available joke provider.
     *
     * @return array
     * @throws ServiceException
     */
    public function getJokeFromAvailableProvider(): array
    {
        $apiProvider = new ApiJokeProviders();
        $availableProvider = $apiProvider->findAvailableProvider();

        if (!$availableProvider) {
            throw new ServiceException(
                "No available joke providers found.",
                self::ERROR_NOT_FOUND
            );
        }

        // Initialize the correct client for the available provider
        $this->initializeClientForProvider($apiProvider->getId());

        $response = $this->clientInstance
            ->setProviderId($apiProvider->getId())
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
        $this->clientInstance = match ($providerId) {
            self::JOKE_API_V2 => new JokeApiV2(),
            self::JOKE_API_V1 => new JokeApiV1(),
            self::JOKE_ALWAYS => new JokeAlways(),
            default => throw new ServiceException("Unsupported provider ID: $providerId", self::ERROR_NOT_FOUND),
        };
    }
}
