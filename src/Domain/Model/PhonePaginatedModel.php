<?php

namespace App\Domain\Model;

use App\Application\Pagination\PaginatedCollection;

/**
 * Class PhonePaginatedModel
 * @author ereshkidal
 */
class PhonePaginatedModel
{
    /**
     * @var array
     */
    public $phones;

    /**
     * @var int
     */
    public $phonesTotal;

    /**
     * @var int
     */
    public $phonesPerPage;

    /**
     * @var array
     */
    public $_links;

    /**
     * @param PaginatedCollection $paginatedCollection
     * @return PhonePaginatedModel
     */
    public static function createFromPaginatedCollection(PaginatedCollection $paginatedCollection): PhonePaginatedModel
    {
        $model = new self();
        $model->phones = $paginatedCollection->getItems();
        $model->phonesTotal = $paginatedCollection->getItemsTotal();
        $model->phonesPerPage = $paginatedCollection->getItemsPerPage();
        $model->_links = $paginatedCollection->getLinks();

        return $model;
    }
}
