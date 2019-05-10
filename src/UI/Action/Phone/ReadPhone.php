<?php

namespace App\UI\Action\Phone;

use App\Domain\Model\PhoneModel;
use App\UI\Factory\ReadEntityFactory;
use App\UI\Responder\ReadCacheResponder;
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
     * @var ReadCacheResponder
     */
    private $responder;

    /**
     * ReadPhone constructor.
     * @param ReadEntityFactory $factory
     * @param ReadCacheResponder $responder
     */
    public function __construct(ReadEntityFactory $factory, ReadCacheResponder $responder)
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
        $latestModifiedTimestamp = $this->factory->build($request->attributes->get('id'), $model, true);
        $this->responder->buildCache($latestModifiedTimestamp);

        if ($this->responder->isCacheValid($request) && !$this->responder->getResponse()->getContent()) {
            return $this->responder->getResponse();
        }

        return $this->responder->createResponse(
            $this->factory->build($request->attributes->get('id'), $model),
            'phone'
        );
    }
}
