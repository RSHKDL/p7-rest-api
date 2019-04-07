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
}
