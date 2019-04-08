<?php

namespace App\Domain\Model\Interfaces;

use App\Application\Pagination\PaginatedCollection;

interface PaginatedModelInterface
{
    /***
     * @param PaginatedCollection $paginatedCollection
     * @return PaginatedModelInterface
     */
    public static function createFromPaginatedCollection(PaginatedCollection $paginatedCollection): PaginatedModelInterface;

    /**
     * @return string
     */
    public function getEntityName(): string;
}
