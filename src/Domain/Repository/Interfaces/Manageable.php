<?php

namespace App\Domain\Repository\Interfaces;

/**
 * Interface Manageable
 * @author ereshkidal
 */
interface Manageable
{
    /**
     * $entity MUST be a valid Entity
     *
     * @param mixed $entity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save($entity): void;

    /**
     * $entity MUST be a valid Entity
     *
     * @param mixed $entity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update($entity): void;

    /**
     * @param string $id
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(string $id): bool;
}
