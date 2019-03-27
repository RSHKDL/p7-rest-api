<?php

namespace App\UI\Factory;

use App\Application\Pagination\PaginatedCollection;
use App\Domain\Repository\PhoneRepository;
use App\UI\Responder\ReadResponder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ReadPhoneListFactory
{
    /**
     * @var PhoneRepository
     */
    private $repository;

    /**
     * @var ReadResponder
     */
    private $responder;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * ReadPhoneListFactory constructor.
     * @param PhoneRepository $repository
     * @param ReadResponder $responder
     */
    public function __construct(
        PhoneRepository $repository,
        ReadResponder $responder,
        UrlGeneratorInterface $urlGenerator
    ){
        $this->repository = $repository;
        $this->responder = $responder;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * TODO: Give the paginator its own factory?
     */
    public function read(Request $request)
    {
        $page = $request->query->getInt('page', 1);
        $queryBuilder = $this->repository->findAllQueryBuilder();
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(10);
        $pagerfanta->setCurrentPage($page);

        $phones = [];
        foreach ($pagerfanta->getCurrentPageResults() as $result) {
            $phones[] = $result;
        }

        $paginatedCollection = new PaginatedCollection($phones, $pagerfanta->getNbResults());
        $route = 'phone_read_collection';
        $routeParams = [];
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

        return $this->responder->respond($paginatedCollection, 'phone_list');
    }
}
