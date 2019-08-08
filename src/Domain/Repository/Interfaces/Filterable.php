<?php

namespace App\Domain\Repository\Interfaces;

use Doctrine\ORM\QueryBuilder;

/**
 * Interface Filterable
 * @author ereshkidal
 */
interface Filterable
{
    /**
     * This QueryBuilder optionally allow filter and sub resource
     *
     * @param string|null $filter
     * @param string|null $parentResourceUuid
     * @return QueryBuilder|null
     */
    public function findAllQueryBuilder(?string $filter = null, ?string $parentResourceUuid = null): ?QueryBuilder;
}
