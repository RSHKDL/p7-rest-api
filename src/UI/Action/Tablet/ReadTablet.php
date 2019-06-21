<?php

namespace App\UI\Action\Tablet;

use App\Domain\Model\TabletModel;
use App\UI\Factory\ReadEntityFactory;
use App\UI\Responder\ReadCacheResponder;
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
     * @var ReadCacheResponder
     */
    private $responder;

    /**
     * ReadTablet constructor.
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
     * @param TabletModel $model
     * @return Response
     * @throws \Exception
     */
    public function __invoke(Request $request, TabletModel $model): Response
    {
        $latestModifiedTimestamp = $this->factory->build($request, $model, true);
        $this->responder->buildCache($latestModifiedTimestamp);

        if ($this->responder->isCacheValid($request) && !$this->responder->getResponse()->getContent()) {
            return $this->responder->getResponse();
        }

        return $this->responder->createResponse(
            $this->factory->build($request, $model),
            'tablet'
        );
    }
}
