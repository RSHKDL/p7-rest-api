<?php

namespace App\UI\Factory;

use App\Application\Helper\LinksHelper;
use App\Application\Pagination\PaginationFactory;
use App\Application\Router\RouteParams;
use App\Domain\Model\Interfaces\PaginatedModelInterface;
use App\Domain\Repository\Interfaces\Cacheable;
use App\Domain\Repository\Interfaces\Filterable;
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
     * @var LinksHelper
     */
    private $linksHelper;

    /**
     * ReadEntityCollectionFactory constructor.
     * @param EntityManagerInterface $entityManager
     * @param PaginationFactory $paginationFactory
     * @param LinksHelper $linksHelper
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        PaginationFactory $paginationFactory,
        LinksHelper $linksHelper
    ) {
        $this->entityManager = $entityManager;
        $this->paginationFactory = $paginationFactory;
        $this->linksHelper = $linksHelper;
    }

    /**
     * @todo Handle the exception with ApiProblem and try/catch them in controller
     * @todo Distinct return value (here int|object) is not good practice :(
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

        if (!$repository instanceof Filterable) {
            throw new \DomainException('Invalid repository : The repository must implement Filterable.');
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
            $routeParams
        );

        $paginatedModel = $paginatedModel::createFromPaginatedCollection($paginatedCollection);
        $this->linksHelper->addLinks($paginatedModel);

        return $paginatedModel;
    }

    /**
     * @param Filterable $repository
     * @param RouteParams $routeParams
     * @return QueryBuilder
     */
    private function getQueryBuilder(Filterable $repository, RouteParams $routeParams): QueryBuilder
    {
        $retailerUuid = $routeParams->getParameters()->get('retailerUuid');
        if ($retailerUuid) {
            return $repository->findAllQueryBuilder($routeParams->getFilter(), $retailerUuid);
        }

        return $repository->findAllQueryBuilder($routeParams->getFilter());
    }
}
