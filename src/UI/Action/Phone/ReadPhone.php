<?php

namespace App\UI\Action\Phone;

use App\Domain\Model\PhoneModel;
use App\UI\Factory\ReadEntityFactory;
use App\UI\Responder\ReadResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/phones/{id}", methods={"GET"}, name="phone_read")
 *
 * Class ReadPhone
 * @author ereshkidal
 */
class ReadPhone
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
     * ReadPhone constructor.
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
     * @param PhoneModel $model
     * @return Response
     * @throws \Exception
     */
    public function __invoke(Request $request, PhoneModel $model): Response
    {
        return $this->responder->respond(
            $this->factory->build($request->attributes->get('id'), $model),
            'phone'
        );
    }
}
