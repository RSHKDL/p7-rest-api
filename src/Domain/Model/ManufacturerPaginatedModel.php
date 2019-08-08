<?php

namespace App\Domain\Model;

use App\Application\Pagination\PaginatedCollection;
use App\Domain\Entity\Manufacturer;
use App\Domain\Model\Interfaces\PaginatedModelInterface;
use App\Domain\Model\Traits\CreateModelsFromEntitiesTrait;

/**
 * Class ManufacturerPaginatedModel
 * @author ereshkidal
 */
final class ManufacturerPaginatedModel implements PaginatedModelInterface
{
    use CreateModelsFromEntitiesTrait;

    private const ENTITY_NAME = Manufacturer::class;

    /**
     * @var ManufacturerModel[]
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
     * @var string[]
     */
    public $_links;

    /**
     * {@inheritdoc}
     */
    public static function createFromPaginatedCollection(PaginatedCollection $paginatedCollection): PaginatedModelInterface
    {
        $model = new self();
        $model->manufacturers = $model->createModelsFromEntities($paginatedCollection->getItems(), new ManufacturerModel());
        $model->manufacturersTotal = $paginatedCollection->getItemsTotal();
        $model->manufacturersPerPage = $paginatedCollection->getItemsPerPage();
        $model->_links = $paginatedCollection->getLinks();

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    /**
     * @return ManufacturerModel[]
     */
    public function getModels(): array
    {
        return $this->manufacturers;
    }
}
