<?php

namespace App\UI\Action\Tablet;

use App\Application\Router\RouteParams;
use App\Domain\Model\TabletPaginatedModel;
use App\UI\Factory\ReadEntityCollectionFactory;
use App\UI\Responder\ReadCacheResponder;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/products/tablets", methods={"GET"}, name=ReadTabletList::ROUTE_NAME)
 *
 * Class ReadTabletList
 * @author ereshkidal
 */
final class ReadTabletList
{
    public const ROUTE_NAME = 'tablet_read_collection';

    /**
     * @var ReadEntityCollectionFactory
     */
    private $factory;

    /**
     * @var ReadCacheResponder
     */
    private $responder;

    /**
     * ReadPhoneList constructor.
     * @param ReadEntityCollectionFactory $factory
     * @param ReadCacheResponder $responder
     */
    public function __construct(
        ReadEntityCollectionFactory $factory,
        ReadCacheResponder $responder
    ) {
        $this->factory = $factory;
        $this->responder = $responder;
    }

    /**
     * Return a collection of tablets
     *
     * @SWG\Response(
     *      response=200,
     *      description="Collection successfully returned",
     *      @SWG\Schema(ref="#/definitions/TabletPaginatedModel")
     * )
     * @SWG\Tag(name="Tablets")
     *
     * @param Request $request
     * @param TabletPaginatedModel $paginatedModel
     * @return Response
     * @throws \Exception
     */
    public function __invoke(Request $request, TabletPaginatedModel $paginatedModel): Response
    {
        $timestamp = $this->factory->build($request, $paginatedModel, null, true);
        if (null === $timestamp) {
            throw new NotFoundHttpException('No Tablets found');
        }
        $this->responder->buildCache($timestamp);

        if ($this->responder->isCacheValid($request) && !$this->responder->getResponse()->getContent()) {
            return $this->responder->getResponse();
        }

        $routeParams = new RouteParams(
            self::ROUTE_NAME,
            $request->attributes->get('_route_params'),
            $request->query->get('filter')
        );

        return $this->responder->createResponse(
            $this->factory->build($request, $paginatedModel, $routeParams),
            'product_collection'
        );
    }
}
