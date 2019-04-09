<?php

namespace App\UI\Action\Manufacturer;

use App\Domain\Model\ManufacturerPaginatedModel;
use App\UI\Factory\ReadEntityCollectionFactory;
use App\UI\Responder\ReadResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/manufacturers", methods={"GET"}, name=ReadManufacturerList::ROUTE_NAME)
 *
 * Class ReadManufacturerList
 * @author ereshkidal
 */
class ReadManufacturerList
{
    public const ROUTE_NAME = 'manufacturer_read_collection';

    /**
     * @var ReadEntityCollectionFactory
     */
    private $factory;

    /**
     * @var ReadResponder
     */
    private $responder;

    /**
     * ReadManufacturerList constructor.
     * @param ReadEntityCollectionFactory $factory
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
     * @param ManufacturerPaginatedModel $manufacturerPaginatedModel
     * @return Response
     * @throws \Exception
     */
    public function __invoke(Request $request, ManufacturerPaginatedModel $manufacturerPaginatedModel): Response
    {
        return $this->responder->respond(
            $this->factory->build($request, $manufacturerPaginatedModel, self::ROUTE_NAME),
            'manufacturer_collection'
        );
    }
}
