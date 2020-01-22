<?php

namespace App\Domain\Model;

use App\Application\Pagination\PaginatedCollection;
use App\Domain\Entity\Retailer;
use App\Domain\Model\Interfaces\PaginatedModelInterface;
use App\Domain\Model\Traits\CreateModelsFromEntitiesTrait;
use Swagger\Annotations as SWG;

/**
 * Class RetailerPaginatedModel
 * @author ereshkidal
 */
final class RetailerPaginatedModel implements PaginatedModelInterface
{
    use CreateModelsFromEntitiesTrait;

    private const ENTITY_NAME = Retailer::class;

    /**
     * @var RetailerModel[]
     * @SWG\Schema(
     *     type="array",
     *     @SWG\Items(ref="#/definitions/RetailerModel_collection")
     * )
     */
    public $retailers;

    /**
     * @var int
     */
    public $retailersTotal;

    /**
     * @var int
     */
    public $retailersPerPage;

    /**
     * @var string[]
     */
    public $_links;

    /**
     * @param PaginatedCollection $paginatedCollection
     * @return PaginatedModelInterface
     * @throws \Exception
     */
    public static function createFromPaginatedCollection(PaginatedCollection $paginatedCollection): PaginatedModelInterface
    {
        $model = new self();
        $model->retailers = $model->createModelsFromEntities($paginatedCollection->getItems(), new RetailerModel());
        $model->retailersTotal = $paginatedCollection->getItemsTotal();
        $model->retailersPerPage = $paginatedCollection->getItemsPerPage();
        $model->_links = $paginatedCollection->getLinks();

        return $model;
    }

    /**
     * @return string
     */
    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    /**
     * @return RetailerModel[]
     */
    public function getModels(): array
    {
        return $this->retailers;
    }
}
