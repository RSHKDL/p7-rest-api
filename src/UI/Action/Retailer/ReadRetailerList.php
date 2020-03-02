<?php

namespace App\UI\Action\Retailer;

use App\Application\Router\RouteParams;
use App\Domain\Model\RetailerPaginatedModel;
use App\UI\Factory\ReadEntityCollectionFactory;
use App\UI\Responder\ReadResponder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/retailers", methods={"GET"}, name=ReadRetailerList::ROUTE_NAME)
 *
 * Class ReadRetailerList
 * @author ereshkidal
 */
final class ReadRetailerList
{
    public const ROUTE_NAME = 'retailer_read_collection';

    /**
     * @var ReadEntityCollectionFactory
     */
    private $factory;

    /**
     * @var ReadResponder
     */
    private $responder;

    /**
     * ReadRetailerList constructor.
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
     * Return a collection of retailers
     *
     * @SWG\Response(
     *      response=200,
     *      description="Collection successfully returned",
     *      @SWG\Schema(ref="#/definitions/RetailerPaginatedModel")
     * )
     * @SWG\Tag(name="Retailers")
     *
     * @param Request $request
     * @param RetailerPaginatedModel $retailerPaginatedModel
     * @return Response
     * @throws \Exception
     *
     * @IsGranted("ROLE_ADMIN", message="Access denied. Credentials too low.")
     */
    public function __invoke(Request $request, RetailerPaginatedModel $retailerPaginatedModel): Response
    {
        $routeParams = new RouteParams(
            self::ROUTE_NAME,
            $request->attributes->get('_route_params')
        );

        return $this->responder->respond(
            $this->factory->build($request, $retailerPaginatedModel, $routeParams),
            'retailer_collection'
        );
    }

}
