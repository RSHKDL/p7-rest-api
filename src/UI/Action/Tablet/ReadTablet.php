<?php

namespace App\UI\Action\Tablet;

use App\Domain\Model\TabletModel;
use App\UI\Factory\ReadEntityFactory;
use App\UI\Responder\ReadResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/products/tablets/{id}", methods={"GET"}, name="tablet_read")
 *
 * Class ReadTablet
 * @author ereshkidal
 */
class ReadTablet
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
     * ReadTablet constructor.
     * @param ReadEntityFactory $factory
     * @param ReadResponder $responder
     */
    public function __construct(ReadEntityFactory $factory, ReadResponder $responder)
    {
        $this->factory = $factory;
        $this->responder = $responder;
    }

    /**
     * @param Request $request
     * @param TabletModel $model
     * @return Response
     * @throws \Exception
     */
    public function __invoke(Request $request, TabletModel $model): Response
    {
        return $this->responder->respond(
            $this->factory->build($request->attributes->get('id'), $model),
            'tablet'
        );
    }
}
