<?php

namespace App\UI\Action\Manufacturer;

use App\Application\Router\RouteParams;
use App\Domain\Model\ManufacturerPaginatedModel;
use App\UI\Factory\ReadEntityCollectionFactory;
use App\UI\Responder\ReadResponder;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/manufacturers", methods={"GET"}, name=ReadManufacturerList::ROUTE_NAME)
 *
 * Class ReadManufacturerList
 * @author ereshkidal
 */
final class ReadManufacturerList
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
     * Return a collection of manufacturers
     *
     * @SWG\Response(
     *      response=200,
     *      description="Collection successfully returned",
     *      @SWG\Schema(ref="#/definitions/ManufacturerPaginatedModel")
     * )
     * @SWG\Tag(name="Manufacturers")
     *
     * @param Request $request
     * @param ManufacturerPaginatedModel $manufacturerPaginatedModel
     * @return Response
     * @throws \Exception
     */
    public function __invoke(Request $request, ManufacturerPaginatedModel $manufacturerPaginatedModel): Response
    {
        $routeParams = new RouteParams(
            self::ROUTE_NAME,
            $request->attributes->get('_route_params')
        );

        return $this->responder->respond(
            $this->factory->build($request, $manufacturerPaginatedModel, $routeParams),
            'manufacturer_collection'
        );
    }
}
