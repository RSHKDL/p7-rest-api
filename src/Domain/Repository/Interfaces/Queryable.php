<?php

namespace App\Domain\Repository\Interfaces;

use Doctrine\ORM\QueryBuilder;

/**
 * Interface Queryable
 * @author ereshkidal
 */
interface Queryable
{
    /**
     * @return QueryBuilder
     */
    public function findAllQueryBuilder(): QueryBuilder;
}
