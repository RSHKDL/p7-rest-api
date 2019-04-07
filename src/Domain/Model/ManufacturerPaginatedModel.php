<?php

namespace App\Domain\Model;

use App\Application\Pagination\PaginatedCollection;

/**
 * Class ManufacturerPaginatedModel
 * @author ereshkidal
 */
class ManufacturerPaginatedModel
{
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
     * @return ManufacturerPaginatedModel
     */
    public static function createFromPaginatedCollection(PaginatedCollection $paginatedCollection): ManufacturerPaginatedModel
    {
        $model = new self();
        $model->manufacturers = $paginatedCollection->getItems();
        $model->manufacturersTotal = $paginatedCollection->getItemsTotal();
        $model->manufacturersPerPage = $paginatedCollection->getItemsPerPage();
        $model->_links = $paginatedCollection->getLinks();

        return $model;
    }
}
