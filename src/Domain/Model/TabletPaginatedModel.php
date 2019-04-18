<?php

namespace App\Domain\Model;

use App\Application\Pagination\PaginatedCollection;
use App\Domain\Entity\Tablet;
use App\Domain\Model\Interfaces\PaginatedModelInterface;

/**
 * Class TabletPaginatedModel
 * @author ereshkidal
 */
class TabletPaginatedModel implements PaginatedModelInterface
{
    private const ENTITY_NAME = Tablet::class;

    /**
     * @var TabletModel[]
     */
    public $tablets;

    /**
     * @var int
     */
    public $tabletsTotal;

    /**
     * @var int
     */
    public $tabletsPerPage;

    /**
     * @var array
     */
    public $_links;

    /**
     * {@inheritdoc}
     */
    static function createFromPaginatedCollection(PaginatedCollection $paginatedCollection): PaginatedModelInterface
    {
        $model = new self();
        $model->tablets = $model->createModelsFromEntities($paginatedCollection->getItems());
        $model->tabletsTotal = $paginatedCollection->getItemsTotal();
        $model->tabletsPerPage = $paginatedCollection->getItemsPerPage();
        $model->_links = $paginatedCollection->getLinks();

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    /**
     * {@inheritdoc}
     */
    function createModelsFromEntities(array $entities): array
    {
        $models = [];
        foreach ($entities as $entity) {
            $models[] = TabletModel::createFromEntity($entity);
        }

        return $models;
    }
}
