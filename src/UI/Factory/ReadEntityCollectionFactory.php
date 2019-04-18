<?php

namespace App\UI\Factory;

use App\Application\Pagination\PaginationFactory;
use App\Domain\Model\Interfaces\PaginatedModelInterface;
use App\Domain\Repository\Interfaces\EntityRepositoryInterface;
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
     * ReadEntityCollectionFactory constructor.
     * @param EntityManagerInterface $entityManager
     * @param PaginationFactory $paginationFactory
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        PaginationFactory $paginationFactory
    ) {
        $this->entityManager = $entityManager;
        $this->paginationFactory = $paginationFactory;
    }

    /**
     * @todo handle the exception with apiProblem ?
     * @param Request $request
     * @param PaginatedModelInterface $paginatedModel
     * @param string $route
     * @return PaginatedModelInterface
     * @throws \Exception
     */
    public function build(Request $request, PaginatedModelInterface $paginatedModel, string $route): PaginatedModelInterface
    {
        $repository = $this->entityManager->getRepository($paginatedModel->getEntityName());
        if (!$repository instanceof EntityRepositoryInterface) {
            throw new \Exception('Invalid repository');
        }

        $queryBuilder = $repository->findAllQueryBuilder();
        $paginatedCollection = $this->paginationFactory->createCollection(
            $queryBuilder,
            $request,
            $route
        );

        return $paginatedModel::createFromPaginatedCollection($paginatedCollection);
    }
}
