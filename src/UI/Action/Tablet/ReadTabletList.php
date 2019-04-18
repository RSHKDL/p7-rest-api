<?php

namespace App\UI\Action\Tablet;

use App\Domain\Model\TabletPaginatedModel;
use App\UI\Factory\ReadEntityCollectionFactory;
use App\UI\Responder\ReadResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/products/tablets", methods={"GET"}, name=ReadTabletList::ROUTE_NAME)
 *
 * Class ReadTabletList
 * @author ereshkidal
 */
class ReadTabletList
{
    public const ROUTE_NAME = 'tablet_read_collection';

    /**
     * @var ReadEntityCollectionFactory
     */
    private $factory;

    /**
     * @var ReadResponder
     */
    private $responder;

    /**
     * ReadPhoneList constructor.
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
     * @param Request $request
     * @param TabletPaginatedModel $paginatedModel
     * @return Response
     * @throws \Exception
     */
    public function __invoke(Request $request, TabletPaginatedModel $paginatedModel): Response
    {
        return $this->responder->respond(
            $this->factory->build($request, $paginatedModel, self::ROUTE_NAME),
            'product_collection'
        );
    }
}
