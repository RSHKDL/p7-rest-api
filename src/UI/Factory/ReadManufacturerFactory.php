<?php

namespace App\UI\Factory;

use App\Application\Pagination\PaginationFactory;
use App\Domain\Repository\ManufacturerRepository;
use App\UI\Responder\ReadResponder;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ReadManufacturerFactory
 * @author ereshkidal
 */
class ReadManufacturerFactory
{
    /**
     * @var ManufacturerRepository
     */
    private $repository;

    /**
     * @var PaginationFactory
     */
    private $paginationFactory;

    /**
     * @var ReadResponder
     */
    private $responder;

    /**
     * ReadManufacturerList constructor.
     * @param ManufacturerRepository $repository
     * @param PaginationFactory $paginationFactory
     * @param ReadResponder $responder
     */
    public function __construct(
        ManufacturerRepository $repository,
        PaginationFactory $paginationFactory,
        ReadResponder $responder
    ){
        $this->repository = $repository;
        $this->paginationFactory = $paginationFactory;
        $this->responder = $responder;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function read(Request $request)
    {
        $queryBuilder = $this->repository->findAllQueryBuilder();
        $paginatedCollection = $this->paginationFactory->createCollection(
            $queryBuilder,
            $request,
            'manufacturer_read_collection'
        );

        return $this->responder->respond($paginatedCollection);
    }
}
