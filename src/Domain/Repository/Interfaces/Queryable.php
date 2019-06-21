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

    /**
     * @param string $retailerUuid
     * @return QueryBuilder|null
     */
    public function findAllByRetailerQueryBuilder(string $retailerUuid): ?QueryBuilder;
}
