<?php

namespace Stdimitrov\Jockstream\Models;

use Stdimitrov\Jockstream\Lib\Database;
use Stdimitrov\Jockstream\Lib\Helper;

class ApiProviderLogs extends Database
{
    // Define table name as a constant
    private const string TABLE_NAME = 'api_provider_logs';

    // Attributes corresponding to the table columns
    protected ?int $id = 0;
    protected ?int $providerId = 0;
    protected ?string $requestUrl = '';
    protected ?int $responseCode = 0;
    protected ?string $errorMessage = '';
    protected ?int $createdAt = 0;

    // Getters and Setters for each property
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getProviderId(): int
    {
        return $this->providerId;
    }

    public function setProviderId(int $id): void
    {
        $this->providerId = $id;
    }


    public function getRequestUrl(): string
    {
        return $this->requestUrl;
    }

    public function setRequestUrl(string $requestUrl): void
    {
        $this->requestUrl = $requestUrl;
    }

    public function getResponseCode(): string
    {
        return $this->responseCode;
    }

    public function setResponseCode(int $responseCode): void
    {
        $this->responseCode = $responseCode;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function setErrorMessage(string $message): void
    {
        $this->errorMessage = $message;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    public function setCreatedAt(int $time): void
    {
        $this->createdAt = $time;
    }

    // Find a log by its ID
    public function findById(int $id): ?self
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE id = ?";
        $details = $this->fetchOne($sql, [$id]);

        if (!$details) {
            return null;
        }

        // Use setters to populate the object
        $this->setId($details->id);
        $this->setProviderId($details->providerId);
        $this->setRequestUrl($details->requestUrl);
        $this->setResponseCode($details->responseCode);
        $this->setErrorMessage($details->errorMessage);
        $this->setCreatedAt($details->createdAt);

        return $this;
    }


    public function create(): ?self
    {
        $params = [
            'provider_id' => $this->getProviderId(),
            'request_url' => $this->getRequestUrl(),
            'response_code' => $this->getResponseCode(),
            'error_message' => $this->getErrorMessage(),
            'created_at' => $this->getCreatedAt(),
        ];

        $params = Helper::prepareSqlParams($params);
        $sql = "INSERT INTO ".self::TABLE_NAME." (" . $params['columns'] . ") VALUES (" . $params['placeholders'] . ")";
        $this->insert($sql, $params['values']);
        return $this;
    }
}
