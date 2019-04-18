<?php

namespace App\Domain\Entity\Traits;

/**
 * Trait TimestampableTrait
 * @author ereshkidal
 */
trait TimestampableTrait
{
    /**
     * @var int
     */
    private $createdAt;

    /**
     * @var int
     */
    private $updatedAt;

    /**
     * Use it in constructor
     */
    public function initTimestampable()
    {
        $this->createdAt = Time();
        $this->updatedAt = Time();
    }

    /**
     * @return int
     */
    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    /**
     * @param int $createdAt
     */
    public function setCreatedAt(int $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getUpdatedAt(): int
    {
        return $this->updatedAt;
    }

    /**
     * @param int $updatedAt
     */
    public function setUpdatedAt(int $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
