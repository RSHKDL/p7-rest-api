<?php

namespace App\UI\Action\Manufacturer;

use App\Domain\Model\ManufacturerModel;
use App\UI\Factory\ReadEntityFactory;
use App\UI\Responder\ReadResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/manufacturers/{manufacturerUuid}", methods={"GET"}, name=ReadManufacturer::ROUTE_NAME)
 *
 * Class ReadManufacturer
 * @author ereshkidal
 */
class ReadManufacturer
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
     * @param Request $request
     * @param ManufacturerModel $model
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function __invoke(Request $request, ManufacturerModel $model)
    {
        return $this->responder->respond(
            $this->factory->build($request, $model, $model->getEntityShortName()),
            'manufacturer'
        );
    }
}
