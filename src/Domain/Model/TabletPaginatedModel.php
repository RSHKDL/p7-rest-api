<?php

namespace App\Domain\Model;

use App\Application\Pagination\PaginatedCollection;
use App\Domain\Entity\Tablet;
use App\Domain\Model\Interfaces\PaginatedModelInterface;
use App\Domain\Model\Traits\CreateModelsFromEntitiesTrait;
use Swagger\Annotations as SWG;

/**
 * Class TabletPaginatedModel
 * @author ereshkidal
 */
final class TabletPaginatedModel implements PaginatedModelInterface
{
    use CreateModelsFromEntitiesTrait;

    private const ENTITY_NAME = Tablet::class;

    /**
     * @var TabletModel[]
     * @SWG\Schema(
     *     type="array",
     *     @SWG\Items(ref="#/definitions/TabletModel_light")
     * )
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
     * @var string[]
     */
    public $_links;

    /**
     * {@inheritdoc}
     */
    public static function createFromPaginatedCollection(PaginatedCollection $paginatedCollection): PaginatedModelInterface
    {
        $model = new self();
        $model->tablets = $model->createModelsFromEntities($paginatedCollection->getItems(), new TabletModel());
        $model->tabletsTotal = $paginatedCollection->getItemsTotal();
        $model->tabletsPerPage = $paginatedCollection->getItemsPerPage();
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
     * @return TabletModel[]
     */
    public function getModels(): array
    {
        return $this->tablets;
    }
}
