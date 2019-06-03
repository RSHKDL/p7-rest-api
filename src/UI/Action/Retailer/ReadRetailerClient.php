<?php

namespace App\UI\Action\Retailer;

use App\Domain\Model\ClientModel;
use App\UI\Factory\ReadEntityFactory;
use App\UI\Responder\ReadResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/retailers/{retailerUuid}/clients/{clientUuid}", methods={"GET"}, name="client_read")
 *
 * Class ReadRetailerClient
 * @author ereshkidal
 */
final class ReadRetailerClient
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
     * ReadRetailerClient constructor.
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
     * @param ClientModel $model
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function __invoke(Request $request, ClientModel $model)
    {
        return $this->responder->respond(
            $this->factory->build($request->attributes->get('clientUuid'), $model),
            'client'
        );
    }
}
