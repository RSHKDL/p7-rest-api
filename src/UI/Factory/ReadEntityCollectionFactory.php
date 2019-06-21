<?php

namespace App\UI\Factory;

use App\Application\Pagination\PaginationFactory;
use App\Application\Router\RouteParams;
use App\Domain\Model\Interfaces\PaginatedModelInterface;
use App\Domain\Repository\Interfaces\Cacheable;
use App\Domain\Repository\Interfaces\Queryable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ReadEntityCollectionFactory
 * @author ereshkidal
 */
final class ReadEntityCollectionFactory
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
     * @param RouteParams|null $routeParams
     * @param bool $checkCache
     * @return int|PaginatedModelInterface
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Exception
     */
    public function build(
        Request $request,
        PaginatedModelInterface $paginatedModel,
        ?RouteParams $routeParams,
        bool $checkCache = false
    ) {
        $repository = $this->entityManager->getRepository($paginatedModel->getEntityName());

        if (!$repository instanceof Queryable) {
            throw new \DomainException('Invalid repository : The repository must implement Queryable.');
        }

        if ($checkCache && $repository instanceof Cacheable) {
            return $repository->getLatestModifiedTimestampAmongAll();
        }

        if (null === $routeParams) {
            throw new \InvalidArgumentException('Route parameters must be provided.');
        }

        $paginatedCollection = $this->paginationFactory->createCollection(
            $this->getQueryBuilder($repository, $routeParams),
            $request,
            $routeParams->getName(),
            $routeParams->getParameters()->toArray()
        );

        return $paginatedModel::createFromPaginatedCollection($paginatedCollection);
    }

    /**
     * @param Queryable $repository
     * @param RouteParams $routeParams
     * @return QueryBuilder
     */
    private function getQueryBuilder(Queryable $repository, RouteParams $routeParams): QueryBuilder
    {
        $retailerUuid = $routeParams->getParameters()->get('retailerUuid');
        if ($retailerUuid) {
            return $repository->findAllByRetailerQueryBuilder($retailerUuid);
        }

        return $repository->findAllQueryBuilder();
    }
}
