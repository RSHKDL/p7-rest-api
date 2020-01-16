<?php

namespace App\Domain\Repository\Interfaces;

/**
 * Interface Cacheable
 * @author ereshkidal
 */
interface Cacheable
{
    /**
     * @param string $id
     * @return null|int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getLatestModifiedTimestamp(string $id): ?int;

    /**
     * @return null|int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getLatestModifiedTimestampAmongAll(): ?int;
}
