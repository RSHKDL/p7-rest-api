<?php

namespace App\Domain\Model;

use App\Application\Pagination\PaginatedCollection;
use App\Domain\Entity\Phone;
use App\Domain\Model\Interfaces\PaginatedModelInterface;
use App\Domain\Model\Traits\CreateModelsFromEntitiesTrait;

/**
 * Class PhonePaginatedModel
 * @author ereshkidal
 */
final class PhonePaginatedModel implements PaginatedModelInterface
{
    use CreateModelsFromEntitiesTrait;

    private const ENTITY_NAME = Phone::class;

    /**
     * @var PhoneModel[]
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
     * {@inheritdoc}
     */
    public static function createFromPaginatedCollection(PaginatedCollection $paginatedCollection): PaginatedModelInterface
    {
        $model = new self();
        $model->phones = $model->createModelsFromEntities($paginatedCollection->getItems(), new PhoneModel());
        $model->phonesTotal = $paginatedCollection->getItemsTotal();
        $model->phonesPerPage = $paginatedCollection->getItemsPerPage();
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
     * @return PhoneModel[]
     */
    public function getModels(): array
    {
        return $this->phones;
    }
}
