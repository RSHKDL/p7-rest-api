<?php

namespace App\UI\Action\Retailer;

use App\Domain\Model\RetailerModel;
use App\UI\Factory\ReadEntityFactory;
use App\UI\Responder\ReadResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
     * @param RetailerModel $model
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function __invoke(Request $request, RetailerModel $model)
    {
        return $this->responder->respond(
            $this->factory->build($request->attributes->get('id'), $model),
            'retailer'
        );
    }
}
