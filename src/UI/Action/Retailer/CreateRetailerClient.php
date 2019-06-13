<?php

namespace App\UI\Action\Retailer;

use App\Domain\Model\ClientModel;
use App\Domain\Repository\RetailerRepository;
use App\UI\Factory\CreateEntityFactory;
use App\UI\Responder\CreateResponder;
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
