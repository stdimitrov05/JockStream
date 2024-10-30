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


    private JockApiV2Interface|JokeApiV1|JokeAlways $clientInstance;

    /**
     * Fetches a joke from an available joke provider.
     *
     * @return array
     * @throws ServiceException
     */
    public function getRandomJoke(): array
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
     * Retrieves a specified number of random jokes from a randomly selected provider.
     *
     * @param int $limit
     * @return array
     * @throws ServiceException
     */
    public function fetchMultipleRandomJokes(int $limit): array
    {
        $provider = new ApiJokeProviders();
        $providerDetails = $provider->findById(rand(self::JOKE_API_V2, self::JOKE_ALWAYS));

        if (!$providerDetails) {
            throw new ServiceException(
                "No joke providers found.",
                self::ERROR_NOT_FOUND
            );
        }
        // Initialize the correct client for the available provider
        $this->initializeClientForProvider($providerDetails->getId());
        $tmpArray = [];

        for ($i = 0; $i <= $limit; $i++) {
            $tmpArray[] = $this->clientInstance
                ->setProviderId($providerDetails->getId())
                ->setHost($providerDetails->getHost())
                ->setApiEndpoint($providerDetails->getApiUri())
                ->getJoke();
        }
        $response = $tmpArray;
        unset($tmpArray);

        $providerDetails->updateUsedTotal();

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
