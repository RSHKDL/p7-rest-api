<?php

namespace App\Domain\Repository\Interfaces;

use Doctrine\ORM\QueryBuilder;

/**
 * Interface EntityRepositoryInterface
 * @author ereshkidal
 */
interface EntityRepositoryInterface
{
    /**
     * @return QueryBuilder
     */
    public function findAllQueryBuilder(): QueryBuilder;

    /**
     * @param string $id
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(string $id): bool;
}
