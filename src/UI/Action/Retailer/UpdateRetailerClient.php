<?php

namespace App\UI\Action\Retailer;

use App\Domain\Model\ClientModel;
use App\UI\Factory\UpdateEntityFactory;
use App\UI\Responder\UpdateResponder;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("/api/retailers/{retailerUuid}/clients/{clientUuid}", methods={"PUT", "PATCH"}, name="client_update")
 *
 * Class UpdateRetailerClient
 * @author ereshkidal
 */
final class UpdateRetailerClient
{
    /**
     * @var UpdateEntityFactory
     */
    private $factory;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * UpdatePhone constructor.
     * @param UpdateEntityFactory $factory
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(
        UpdateEntityFactory $factory,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->factory = $factory;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * Update a client
     *
     * @SWG\Response(
     *      response=200,
     *      description="Client successfully updated",
     *      @SWG\Schema(ref="#/definitions/ClientModel")
     * )
     * @SWG\Response(
     *      response=400,
     *      description="There was a validation error",
     *      @SWG\Schema(ref="#/definitions/ApiProblem")
     * )
     * @SWG\Response(
     *      response=401,
     *      description="Access denied",
     *      @SWG\Schema(ref="#/definitions/ApiProblem")
     * )
     * @SWG\Response(
     *      response=404,
     *      description="Client not found",
     *      @SWG\Schema(ref="#/definitions/ApiProblem")
     * )
     *
     * @SWG\Tag(name="Clients")
     *
     * @param Request $request
     * @param UpdateResponder $responder
     * @param ClientModel $model
     * @return Response
     * @throws \Exception
     */
    public function __invoke(Request $request, UpdateResponder $responder, ClientModel $model): Response
    {
        $retailerUuid = $request->attributes->get('retailerUuid');
        if (!$this->authorizationChecker->isGranted('edit', $retailerUuid)) {
            throw new AccessDeniedHttpException('Access denied');
        }
        $updatedModel = $this->factory->update($request, $model);

        return $responder($updatedModel, 'client', 'client_read');
    }
}
