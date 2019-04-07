<?php

namespace App\UI\Action\Manufacturer;

use App\Domain\Entity\Manufacturer;
use App\UI\Factory\ReadEntityCollectionFactory;
use App\UI\Responder\ReadResponder;
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
     * @var ReadEntityCollectionFactory
     */
    private $factory;

    /**
     * @var ReadResponder
     */
    private $responder;

    /**
     * ReadManufacturerList constructor.
     * @param ReadEntityCollectionFactory $factory
     */
    public function __construct(
        ReadEntityCollectionFactory $factory,
        ReadResponder $responder
    ) {
        $this->factory = $factory;
        $this->responder = $responder;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        return $this->responder->respond($this->factory->read($request, Manufacturer::class, 'manufacturer_read_collection'));
    }
}
