<?php

namespace App\UI\Action\Manufacturer;

use App\UI\Factory\ReadManufacturerFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/manufacturers", methods={"GET"}, name="manufacturer_read_collection")
 *
 * Class ReadManufacturerList
 * @author ereshkidal
 */
class ReadManufacturerList
{
    /**
     * @var ReadManufacturerFactory
     */
    private $factory;

    /**
     * ReadManufacturerList constructor.
     * @param ReadManufacturerFactory $factory
     */
    public function __construct(ReadManufacturerFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        return $this->factory->read($request);
    }
}
