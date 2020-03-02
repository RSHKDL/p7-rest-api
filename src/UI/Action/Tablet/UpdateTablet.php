<?php

namespace App\UI\Action\Tablet;

use App\Domain\Model\TabletModel;
use App\UI\Factory\UpdateEntityFactory;
use App\UI\Responder\UpdateResponder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/products/tablets/{id}", methods={"PUT", "PATCH"}, name="tablet_update")
 *
 * Class UpdateTablet
 * @author ereshkidal
 */
final class UpdateTablet
{
    /**
     * @var UpdateEntityFactory
     */
    private $factory;

    /**
     * UpdatePhone constructor.
     * @param UpdateEntityFactory $factory
     */
    public function __construct(UpdateEntityFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Update a tablet
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="Must be a valid version 4 Uuid"
     * )
     * @SWG\Response(
     *      response=200,
     *      description="Tablet successfully updated",
     *      @SWG\Schema(ref="#/definitions/TabletModel")
     * )
     * @SWG\Response(
     *      response=400,
     *      description="There was a validation error",
     *      @SWG\Schema(ref="#/definitions/ApiProblem")
     * )
     * @SWG\Response(
     *      response=404,
     *      description="Tablet not found",
     *      @SWG\Schema(ref="#/definitions/ApiProblem")
     * )
     * @SWG\Tag(name="Tablets")
     *
     * @param Request $request
     * @param UpdateResponder $responder
     * @param TabletModel $model
     * @return Response
     * @throws \Exception
     *
     * @IsGranted("ROLE_ADMIN", message="Access denied. Credentials too low.")
     */
    public function __invoke(Request $request, UpdateResponder $responder, TabletModel $model)
    {
        $updatedModel = $this->factory->update($request, $model);

        return $responder($updatedModel, 'tablet', 'tablet_read');
    }
}
