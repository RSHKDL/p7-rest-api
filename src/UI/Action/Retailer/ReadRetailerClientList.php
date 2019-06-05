<?php

namespace App\UI\Action\Retailer;

use App\Domain\Model\ClientPaginatedModel;
use App\UI\Factory\ReadEntityCollectionFactory;
use App\UI\Responder\ReadResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/retailers/{retailerUuid}/clients", methods={"GET"}, name=ReadRetailerClientList::ROUTE_NAME)
 *
 * Class ReadRetailerClientList
 * @author ereshkidal
 */
final class ReadRetailerClientList
{
    public const ROUTE_NAME = 'client_read_collection';

    /**
     * @var ReadEntityCollectionFactory
     */
    private $factory;

    /**
     * @var ReadResponder
     */
    private $responder;

    /**
     * ReadRetailerClientList constructor.
     * @param ReadEntityCollectionFactory $factory
     * @param ReadResponder $responder
     */
    public function __construct(
        ReadEntityCollectionFactory $factory,
        ReadResponder $responder
    ) {
        $this->factory = $factory;
        $this->responder = $responder;
    }

    /**
     * @todo improve params distribution (route name and params should be grouped)
     * @param Request $request
     * @param ClientPaginatedModel $paginatedModel
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function __invoke(Request $request, ClientPaginatedModel $paginatedModel): Response
    {
        $param = $request->attributes->get('retailerUuid');

        return $this->responder->respond(
            $this->factory->build($request, $paginatedModel, $param, self::ROUTE_NAME),
            'client_collection'
        );
    }
}