<?php

namespace App\Application\Pagination;

use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class PaginationFactory
 * @author ereshkidal
 */
final class PaginationFactory
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * PaginationFactory constructor.
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param Request $request
     * @param string $route
     * @param array $routeParams
     * @return PaginatedCollection
     */
    public function createCollection(
        QueryBuilder $queryBuilder,
        Request $request,
        string $route,
        array $routeParams = []
    ): PaginatedCollection {
        $page = $request->query->getInt('page', 1);
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(10);
        $pagerfanta->setCurrentPage($page);

        $items = [];
        foreach ($pagerfanta->getCurrentPageResults() as $result) {
            $items[] = $result;
        }

        $paginatedCollection = new PaginatedCollection($items, $pagerfanta->getNbResults());

        $createLinkUrl = function ($targetPage) use ($route, $routeParams) {
            return $this->urlGenerator->generate($route, array_merge(
                $routeParams,
                ['page' => $targetPage]
            ));
        };
        $paginatedCollection->addLink('self', $createLinkUrl($page));
        $paginatedCollection->addLink('first', $createLinkUrl(1));
        $paginatedCollection->addLink('last', $createLinkUrl($pagerfanta->getNbPages()));

        if ($pagerfanta->hasNextPage()) {
            $paginatedCollection->addLink('next', $createLinkUrl($pagerfanta->getNextPage()));
        }

        if ($pagerfanta->hasPreviousPage()) {
            $paginatedCollection->addLink('previous', $createLinkUrl($pagerfanta->getPreviousPage()));
        }

        return $paginatedCollection;
    }
}
