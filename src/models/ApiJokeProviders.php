<?php

namespace Stdimitrov\Jockstream\Models;

use Stdimitrov\Jockstream\Lib\Database;

class ApiJokeProviders extends Database
{
    // Define table name as a constant
    private const string TABLE_NAME = 'api_joke_providers';

    // Attributes corresponding to the table columns
    protected ?int $id = 0;
    protected ?string $host = '';
    protected ?string $apiUri = '';
    protected ?int $isActivated = null;
    protected ?int $totalUsed = null;

    // Getters and Setters for each property
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    public function getApiUri(): string
    {
        return $this->apiUri;
    }

    public function setApiUri(string $apiUri): void
    {
        $this->apiUri = $apiUri;
    }

    public function getIsActivated(): int
    {
        return $this->isActivated;
    }

    public function setIsActivated(int $isActivated): void
    {
        $this->isActivated = $isActivated;
    }

    public function getTotalUsed(): int
    {
        return $this->totalUsed;
    }

    public function setTotalUsed(int $totalUsed): void
    {
        $this->totalUsed = $totalUsed;
    }

    // Find a provider by its ID
    public function findById(int $id): ?self
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE id = ?";
        $details = $this->fetchOne($sql, [$id]);

        if (!$details) {
            return null;
        }

        // Use setters to populate the object
        $this->setId($details->id);
        $this->setHost($details->host);
        $this->setApiUri($details->apiUri);
        $this->setIsActivated($details->isActivated);
        $this->setTotalUsed($details->totalUsed);

        return $this;
    }

    // Find the first available (activated) joke provider
    public function findAvailableProvider(): ?self
    {
        $sql = "
            SELECT id 
            FROM " . self::TABLE_NAME . "
            WHERE is_activated = 1
            ORDER BY total_used ASC
            LIMIT 1
        ";
        $providerId = $this->fetchColumn($sql);

        if (!$providerId) {
            return null;
        }

        return $this->findById($providerId);
    }

    // Increment the totalUsed count for the current provider
    public function updateUsedTotal(): void
    {
        $total = $this->totalUsed + 1;

        $sql = "
            UPDATE " . self::TABLE_NAME . " 
            SET total_used = ? 
            WHERE id = ?
        ";
        $this->update($sql, [$total, $this->id]);

        // Update local object state after successful DB update
        $this->setTotalUsed($total);
    }
}
