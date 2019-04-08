<?php

namespace App\UI\Factory;

use App\Application\Pagination\PaginationFactory;
use App\Domain\Entity\Manufacturer;
use App\Domain\Entity\Phone;
use App\Domain\Model\Interfaces\PaginatedModelInterface;
use App\Domain\Model\ManufacturerPaginatedModel;
use App\Domain\Model\PhonePaginatedModel;
use App\UI\Responder\ReadResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ReadEntityCollectionFactory
 * @author ereshkidal
 */
class ReadEntityCollectionFactory
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var PaginationFactory
     */
    private $paginationFactory;

    /**
     * @var ReadResponder
     */
    private $responder;

    public function __construct(
        EntityManagerInterface $entityManager,
        PaginationFactory $paginationFactory,
        ReadResponder $responder
    ) {
        $this->entityManager = $entityManager;
        $this->paginationFactory = $paginationFactory;
        $this->responder = $responder;
    }

    public function read(Request $request, PaginatedModelInterface $paginatedModel, string $route)
    {
        $repository = $this->entityManager->getRepository($paginatedModel->getEntityName());

        $queryBuilder = $repository->findAllQueryBuilder();
        $paginatedCollection = $this->paginationFactory->createCollection(
            $queryBuilder,
            $request,
            $route
        );

        return $paginatedModel::createFromPaginatedCollection($paginatedCollection);
    }
}
