<?php

namespace App\UI\Action\Tablet;

use App\Domain\Model\TabletModel;
use App\UI\Factory\CreateEntityFactory;
use App\UI\Responder\CreateResponder;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/products/tablets", methods={"POST"}, name="tablet_create")
 *
 * Class CreateTablet
 * @author ereshkidal
 */
final class CreateTablet
{
    /**
     * @var CreateEntityFactory
     */
    private $factory;

    /**
     * CreatePhone constructor.
     * @param CreateEntityFactory $factory
     */
    public function __construct(CreateEntityFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Create a tablet
     *
     * @SWG\Response(
     *      response=201,
     *      description="Tablet successfully created",
     *      @SWG\Schema(ref="#/definitions/TabletModel")
     * )
     * @SWG\Response(
     *      response=400,
     *      description="There was a validation error",
     *      @SWG\Schema(ref="#/definitions/ApiProblem")
     * )
     * @SWG\Tag(name="Tablets")
     *
     * @param Request $request
     * @param CreateResponder $responder
     * @param TabletModel $tabletModel
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __invoke(Request $request, CreateResponder $responder, TabletModel $tabletModel): Response
    {
        $model = $this->factory->create($request, $tabletModel);

        return $responder($model, 'tablet', 'tablet_read');
    }
}
