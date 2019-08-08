<?php

namespace App\UI\Action\Phone;

use App\Domain\Model\PhoneModel;
use App\UI\Factory\UpdateEntityFactory;
use App\UI\Responder\UpdateResponder;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/products/phones/{id}", methods={"PUT", "PATCH"}, name="phone_update")
 *
 * Class UpdatePhone
 * @author ereshkidal
 */
final class UpdatePhone
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
     * Update a phone
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="Must be a valid version 4 Uuid"
     * )
     * @SWG\Response(
     *      response=200,
     *      description="Phone successfully updated",
     *      @Model(type=PhoneModel::class, groups={"phone"})
     * )
     * @SWG\Response(
     *      response=400,
     *      description="There was a validation error",
     *      @Model(type=App\UI\Errors\ApiProblem::class)
     * )
     * @SWG\Response(
     *      response=404,
     *      description="Phone not found",
     *      @Model(type=App\UI\Errors\ApiProblem::class)
     * )
     * @SWG\Tag(name="Phones")
     *
     * @param Request $request
     * @param UpdateResponder $responder
     * @param PhoneModel $model
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function __invoke(Request $request, UpdateResponder $responder, PhoneModel $model)
    {
        $updatedModel = $this->factory->update($request, $model);

        return $responder($updatedModel, 'phone', 'phone_read');
    }
}
