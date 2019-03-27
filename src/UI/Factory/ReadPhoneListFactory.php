<?php

namespace App\UI\Factory;

use App\Application\Pagination\PaginationFactory;
use App\Domain\Repository\PhoneRepository;
use App\UI\Responder\ReadResponder;
use Symfony\Component\HttpFoundation\Request;

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
     * @var PaginationFactory
     */
    private $paginationFactory;

    /**
     * ReadPhoneListFactory constructor.
     * @param PhoneRepository $repository
     * @param ReadResponder $responder
     */
    public function __construct(
        PhoneRepository $repository,
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
            'phone_read_collection'
        );

        return $this->responder->respond($paginatedCollection, 'phone_list');
    }
}
