<?php

namespace App\UI\Action\Retailer;

use App\Domain\Model\ClientModel;
use App\UI\Factory\ReadEntityFactory;
use App\UI\Responder\ReadResponder;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("/api/retailers/{retailerUuid}/clients/{clientUuid}", methods={"GET"}, name="client_read")
 *
 * Class ReadRetailerClient
 * @author ereshkidal
 */
final class ReadRetailerClient
{
    /**
     * @var ReadEntityFactory
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
     * ReadRetailerClient constructor.
     * @param ReadEntityFactory $factory
     * @param ReadResponder $responder
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(
        ReadEntityFactory $factory,
        ReadResponder $responder,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->factory = $factory;
        $this->responder = $responder;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * Return a client belonging to a retailer
     *
     * @SWG\Parameter(
     *     name="retailerUuid",
     *     in="path",
     *     type="string",
     *     description="Must be a valid version 4 Uuid"
     * )
     * @SWG\Parameter(
     *     name="clientUuid",
     *     in="path",
     *     type="string",
     *     description="Must be a valid version 4 Uuid"
     * )
     * @SWG\Response(
     *      response=200,
     *      description="Client successfully returned",
     *      @SWG\Schema(ref="#/definitions/ClientModel")
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
     * @param ClientModel $model
     * @return Response
     * @throws \Exception
     */
    public function __invoke(Request $request, ClientModel $model): Response
    {
        if (!$this->authorizationChecker->isGranted('view', $request->attributes->get('retailerUuid'))) {
            throw new AccessDeniedHttpException('Access denied');
        }

        /** @var ClientModel $clientModel */
        $clientModel = $this->factory->build($request, $model);

        if (!$this->authorizationChecker->isGranted('view', $clientModel->getParentId())) {
            throw new NotFoundHttpException(sprintf('No client found with uuid: %s', $clientModel->getId()));
        }

        return $this->responder->respond(
            $clientModel,
            'client'
        );
    }
}
