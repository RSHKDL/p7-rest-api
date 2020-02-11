<?php

namespace App\UI\Action\Retailer;

use App\Domain\Model\ClientModel;
use App\Domain\Repository\RetailerRepository;
use App\UI\Factory\CreateEntityFactory;
use App\UI\Responder\CreateResponder;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("/api/retailers/{retailerUuid}/clients", methods={"POST"}, name="client_create")
 *
 * Class CreateRetailerClient
 * @author ereshkidal
 */
final class CreateRetailerClient
{
    /**
     * @var CreateEntityFactory
     */
    private $factory;

    /**
     * @var RetailerRepository
     */
    private $retailerRepository;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * CreateRetailerClient constructor.
     * @param CreateEntityFactory $factory
     * @param RetailerRepository $retailerRepository
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(
        CreateEntityFactory $factory,
        RetailerRepository $retailerRepository,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->factory = $factory;
        $this->retailerRepository = $retailerRepository;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * Create a client
     *
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="You must provide this data to create a client",
     *     required=true,
     *     @SWG\Schema(
     *         @SWG\Property(property="firstName", type="string", example="John"),
     *         @SWG\Property(property="lastName", type="string", example="Doe"),
     *         @SWG\Property(property="gender", type="integer", example="0 = other, 1 = female, 2 = male"),
     *         @SWG\Property(property="email", type="string", example="john.doe@gmail.com"),
     *     )
     * )
     *
     * @SWG\Response(
     *      response=201,
     *      description="Client successfully created",
     *      @SWG\Schema(ref="#/definitions/ClientModel")
     * )
     * @SWG\Response(
     *      response=400,
     *      description="There was a validation error",
     *      @SWG\Schema(ref="#/definitions/ApiProblem")
     * )
     * @SWG\Tag(name="Clients")
     *
     * @param Request $request
     * @param CreateResponder $responder
     * @param ClientModel $model
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __invoke(Request $request, CreateResponder $responder, ClientModel $model): Response
    {
        $retailerUuid = $request->attributes->get('retailerUuid');
        if (!$this->authorizationChecker->isGranted('edit', $retailerUuid)) {
            throw new AccessDeniedHttpException('Access denied');
        }
        $retailer = $this->retailerRepository->find($retailerUuid);
        $client = $this->factory->create($request, $model, ['retailer' => $retailer]);

        return $responder($client, 'client', 'client_read');
    }
}
