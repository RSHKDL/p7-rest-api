<?php

namespace App\UI\Action\Manufacturer;

use App\Domain\Model\ManufacturerModel;
use App\UI\Factory\ReadEntityFactory;
use App\UI\Responder\ReadResponder;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/manufacturers/{manufacturerUuid}", methods={"GET"}, name=ReadManufacturer::ROUTE_NAME)
 *
 * Class ReadManufacturer
 * @author ereshkidal
 */
final class ReadManufacturer
{
    public const ROUTE_NAME = 'manufacturer_read';

    /**
     * @var ReadEntityFactory
     */
    private $factory;

    /**
     * @var ReadResponder
     */
    private $responder;

    /**
     * ReadManufacturer constructor.
     * @param ReadEntityFactory $factory
     * @param ReadResponder $responder
     */
    public function __construct(
        ReadEntityFactory $factory,
        ReadResponder $responder
    ) {
        $this->factory = $factory;
        $this->responder = $responder;
    }

    /**
     * Return a manufacturer
     *
     * @SWG\Parameter(
     *     name="manufacturerUuid",
     *     in="path",
     *     type="string",
     *     description="Must be a valid version 4 Uuid"
     * )
     * @SWG\Response(
     *      response=200,
     *      description="Manufacturer successfully returned",
     *      @SWG\Schema(ref="#/definitions/ManufacturerModel_full")
     * )
     * @SWG\Response(
     *      response=400,
     *      description="Invalid Uuid provided",
     *      @SWG\Schema(ref="#/definitions/ApiProblem")
     * )
     * @SWG\Response(
     *      response=404,
     *      description="Manufacturer not found",
     *      @SWG\Schema(ref="#/definitions/ApiProblem")
     * )
     * @SWG\Tag(name="Manufacturers")
     *
     * @param Request $request
     * @param ManufacturerModel $model
     * @return Response
     * @throws \Exception
     */
    public function __invoke(Request $request, ManufacturerModel $model)
    {
        return $this->responder->respond(
            $this->factory->build($request, $model),
            'manufacturer'
        );
    }
}
