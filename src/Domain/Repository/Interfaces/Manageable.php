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
     * @param bool $update
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveOrUpdate($entity, bool $update = false): void;

    /**
     * $entity MUST be a valid Entity
     *
     * @param mixed $entity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove($entity): void;
}
