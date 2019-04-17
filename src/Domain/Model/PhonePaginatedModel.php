<?php

namespace App\Domain\Model;

use App\Application\Pagination\PaginatedCollection;
use App\Domain\Entity\Phone;
use App\Domain\Model\Interfaces\PaginatedModelInterface;

/**
 * Class PhonePaginatedModel
 * @author ereshkidal
 */
class PhonePaginatedModel implements PaginatedModelInterface
{
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
        $model->phones = $model->createModelsFromEntities($paginatedCollection->getItems());
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
     * {@inheritdoc}
     */
    public function createModelsFromEntities(array $entities): array
    {
        $models = [];
        foreach ($entities as $phone) {
            $models[] = PhoneModel::createFromEntity($phone);
        }

        return $models;
    }
}
