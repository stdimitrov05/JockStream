<?php

namespace Stdimitrov\Jockstream\Services;

use Stdimitrov\Jockstream\Exceptions\ServiceException;
use Stdimitrov\Jockstream\Interfaces\JockApiV2Interface;
use Stdimitrov\Jockstream\Lib\JokeAlways;
use Stdimitrov\Jockstream\Lib\JokeApiV1;
use Stdimitrov\Jockstream\Lib\JokeApiV2;
use Stdimitrov\Jockstream\Models\ApiJokeProviders;
use Stdimitrov\Jockstream\Models\ApiProviderLogs;

class LogsServices extends AbstractService
{
    private string $requestUrl;

    public function setRequestUrl(string $requestUrl): void
    {
        $this->requestUrl = $requestUrl;
    }

    public function error(int $providerId, string $message, int $code): void
    {
        $log = new ApiProviderLogs();
        $log->setProviderId($providerId);
        $log->setErrorMessage($message);
        $log->setResponseCode($code);
        $log->setRequestUrl($this->requestUrl);
        $log->setCreatedAt(time());
        $log->create();
    }
}
