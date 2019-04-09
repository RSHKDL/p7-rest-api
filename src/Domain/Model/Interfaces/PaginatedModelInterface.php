<?php

namespace App\Domain\Model\Interfaces;

use App\Application\Pagination\PaginatedCollection;

interface PaginatedModelInterface
{
    /***
     * @param PaginatedCollection $paginatedCollection
     * @return PaginatedModelInterface
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
