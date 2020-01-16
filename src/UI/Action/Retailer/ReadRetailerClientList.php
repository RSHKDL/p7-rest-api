<?php

namespace App\UI\Action\Retailer;

use App\Application\Router\RouteParams;
use App\Domain\Model\ClientPaginatedModel;
use App\UI\Factory\ReadEntityCollectionFactory;
use App\UI\Responder\ReadResponder;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

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
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * ReadRetailerClientList constructor.
     * @param ReadEntityCollectionFactory $factory
     * @param ReadResponder $responder
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(
        ReadEntityCollectionFactory $factory,
        ReadResponder $responder,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->factory = $factory;
        $this->responder = $responder;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * Return a collection of clients belonging to a retailer
     *
     * @SWG\Parameter(
     *     name="retailerUuid",
     *     in="path",
     *     type="string",
     *     description="Must be a valid version 4 Uuid"
     * )
     * @SWG\Response(
     *      response=200,
     *      description="Collection successfully returned",
     *      @SWG\Schema(ref="#/definitions/ClientPaginatedModel")
     * )
     * @SWG\Response(
     *      response=400,
     *      description="Invalid Uuid provided",
     *      @SWG\Schema(ref="#/definitions/ApiProblem")
     * )
     * @SWG\Response(
     *      response=401,
     *      description="Access denied",
     *      @SWG\Schema(ref="#/definitions/ApiProblem")
     * )
     * @SWG\Tag(name="Clients")
     *
     * @param Request $request
     * @param ClientPaginatedModel $paginatedModel
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function __invoke(Request $request, ClientPaginatedModel $paginatedModel): Response
    {
        if (!$this->authorizationChecker->isGranted('view', $request->attributes->get('retailerUuid'))) {
            throw new AccessDeniedHttpException('Access denied');
        }

        $routeParams = new RouteParams(
            self::ROUTE_NAME,
            $request->attributes->get('_route_params'),
            $request->query->get('filter')
        );

        return $this->responder->respond(
            $this->factory->build($request, $paginatedModel, $routeParams),
            'client_collection'
        );
    }
}
