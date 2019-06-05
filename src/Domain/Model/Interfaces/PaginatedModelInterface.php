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
    public static function createFromPaginatedCollection(PaginatedCollection $paginatedCollection): PaginatedModelInterface;

    /**
     * @return string
     */
    public function getEntityName(): string;

    /**
     * @todo adapt all PaginatedModel
     * @param array $entities
     * @param null|ModelInterface $model
     * @return array
     */
    //public function createModelsFromEntities(array $entities, ?ModelInterface $model): array;
}
