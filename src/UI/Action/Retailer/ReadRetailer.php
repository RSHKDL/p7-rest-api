<?php

namespace App\UI\Action\Retailer;

use App\Domain\Model\RetailerModel;
use App\UI\Factory\ReadEntityFactory;
use App\UI\Responder\ReadResponder;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("/api/retailers/{retailerUuid}", methods={"GET"}, name="retailer_read")
 *
 * Class ReadRetailer
 * @author ereshkidal
 */
final class ReadRetailer
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
     * Return a retailer
     *
     * @SWG\Parameter(
     *     name="retailerUuid",
     *     in="path",
     *     type="string",
     *     description="Must be a valid version 4 Uuid"
     * )
     * @SWG\Response(
     *      response=200,
     *      description="Retailer successfully returned",
     *      @SWG\Schema(ref="#/definitions/RetailerModel")
     * )
     * @SWG\Response(
     *      response=400,
     *      description="Invalid Uuid provided",
     *      @SWG\Schema(ref="#/definitions/ApiProblem")
     * )
     * @SWG\Response(
     *      response=404,
     *      description="Retailer not found",
     *      @SWG\Schema(ref="#/definitions/ApiProblem")
     * )
     * @SWG\Tag(name="Retailers")
     *
     * @param Request $request
     * @param RetailerModel $model
     * @return Response
     * @throws \Exception
     */
    public function __invoke(Request $request, RetailerModel $model)
    {
        if (!$this->authorizationChecker->isGranted('view', $request->attributes->get('retailerUuid'))) {
            throw new NotFoundHttpException('This retailer does not exist.');
        }

        return $this->responder->respond(
            $this->factory->build($request, $model),
            'retailer'
        );
    }
}
