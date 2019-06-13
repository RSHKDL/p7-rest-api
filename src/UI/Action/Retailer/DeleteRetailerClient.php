<?php

namespace App\UI\Action\Retailer;

use App\Domain\Model\ClientModel;
use App\UI\Factory\DeleteEntityFactory;
use App\UI\Responder\DeleteResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("/api/retailers/{retailerUuid}/clients/{clientUuid}", methods={"DELETE"}, name="client_delete")
 *
 * Class DeleteRetailerClient
 * @author ereshkidal
 */
final class DeleteRetailerClient
{
    /**
     * @var DeleteEntityFactory
     */
    private $factory;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * DeleteRetailerClient constructor.
     * @param DeleteEntityFactory $factory
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(
        DeleteEntityFactory $factory,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->factory = $factory;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param Request $request
     * @param DeleteResponder $responder
     * @param ClientModel $model
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __invoke(Request $request, DeleteResponder $responder, ClientModel $model): Response
    {
        if (!$this->authorizationChecker->isGranted('edit', $request->attributes->get('retailerUuid'))) {
            throw new AccessDeniedHttpException('Access denied');
        }
        $this->factory->remove($request->attributes->get('clientUuid'), $model);

        return $responder();
    }
}
