<?php

namespace App\Domain\Model;

use App\Application\Pagination\PaginatedCollection;
use App\Domain\Entity\Client;
use App\Domain\Model\Interfaces\PaginatedModelInterface;
use App\Domain\Model\Traits\CreateFromEntityTrait;

/**
 * Class ClientPaginatedModel
 * @author ereshkidal
 */
final class ClientPaginatedModel implements PaginatedModelInterface
{
    use CreateFromEntityTrait;

    private const ENTITY_NAME = Client::class;

    /**
     * @var ClientModel[]
     */
    public $clients;

    /**
     * @var int
     */
    public $clientsTotal;

    /**
     * @var int
     */
    public $clientsPerPage;

    /**
     * @var array
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
        $model->clients = $model->createModelsFromEntities($paginatedCollection->getItems(), new ClientModel());
        $model->clientsTotal = $paginatedCollection->getItemsTotal();
        $model->clientsPerPage = $paginatedCollection->getItemsPerPage();
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
}
