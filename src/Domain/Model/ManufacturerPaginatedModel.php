<?php

namespace App\Domain\Model;

use App\Application\Pagination\PaginatedCollection;
use App\Domain\Entity\Manufacturer;
use App\Domain\Model\Interfaces\PaginatedModelInterface;

/**
 * Class ManufacturerPaginatedModel
 * @author ereshkidal
 */
class ManufacturerPaginatedModel implements PaginatedModelInterface
{
    private const ENTITY = Manufacturer::class;

    /**
     * @var array
     */
    public $manufacturers;

    /**
     * @var int
     */
    public $manufacturersTotal;

    /**
     * @var int
     */
    public $manufacturersPerPage;

    /**
     * @var array
     */
    public $_links;

    /**
     * @param PaginatedCollection $paginatedCollection
     * @return PaginatedModelInterface
     */
    public static function createFromPaginatedCollection(PaginatedCollection $paginatedCollection): PaginatedModelInterface
    {
        $model = new self();
        $model->manufacturers = $paginatedCollection->getItems();
        $model->manufacturersTotal = $paginatedCollection->getItemsTotal();
        $model->manufacturersPerPage = $paginatedCollection->getItemsPerPage();
        $model->_links = $paginatedCollection->getLinks();

        return $model;
    }

    /**
     * @return string
     */
    public function getEntityName(): string
    {
        return self::ENTITY;
    }
}
