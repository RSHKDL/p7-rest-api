<?php

namespace App\UI\Action\Retailer;

use App\Domain\Model\RetailerModel;
use App\UI\Factory\ReadEntityFactory;
use App\UI\Responder\ReadResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("/api/retailers/{id}", methods={"GET"}, name="retailer_read")
 *
 * Class ReadRetailer
 * @author ereshkidal
 */
class ReadRetailer
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
     * ReadManufacturer constructor.
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
     * @param Request $request
     * @param RetailerModel $model
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function __invoke(Request $request, RetailerModel $model)
    {
        $hydratedModel = $this->factory->build($request->attributes->get('id'), $model);
        if (!$this->authorizationChecker->isGranted('view', $hydratedModel)) {
            throw new NotFoundHttpException('This retailer does not exist');
        }

        return $this->responder->respond(
            $hydratedModel,
            'retailer'
        );
    }
}
