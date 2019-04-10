<?php

namespace App\Domain\Model\Interfaces;

use App\Application\Pagination\PaginatedCollection;

/**
 * Interface PaginatedModelInterface
 * @author ereshkidal
 */
interface PaginatedModelInterface
{
    /**
     * @param PaginatedCollection $paginatedCollection
     * @return PaginatedModelInterface
     * @throws \Exception
     */
    static function createFromPaginatedCollection(PaginatedCollection $paginatedCollection): PaginatedModelInterface;

    /**
     * @return string
     */
    function getEntityName(): string;

    /**
     * @param array $entities
     * @return array
     * @throws \Exception
     */
    function createModelsFromEntities(array $entities): array;
}
