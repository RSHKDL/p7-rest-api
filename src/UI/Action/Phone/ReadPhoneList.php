<?php

namespace App\UI\Action\Phone;

use App\Domain\Model\PhonePaginatedModel;
use App\UI\Factory\ReadEntityCollectionFactory;
use App\UI\Responder\ReadCacheResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/products/phones", methods={"GET"}, name=ReadPhoneList::ROUTE_NAME)
 *
 * Class ReadPhoneList
 * @author ereshkidal
 */
class ReadPhoneList
{
    public const ROUTE_NAME = 'phone_read_collection';

    /**
     * @var ReadEntityCollectionFactory
     */
    private $factory;

    /**
     * @var ReadCacheResponder
     */
    private $responder;

    /**
     * ReadPhoneList constructor.
     * @param ReadEntityCollectionFactory $factory
     * @param ReadCacheResponder $responder
     */
    public function __construct(
        ReadEntityCollectionFactory $factory,
        ReadCacheResponder $responder
    ) {
        $this->factory = $factory;
        $this->responder = $responder;
    }

    /**
     * @param Request $request
     * @param PhonePaginatedModel $paginatedModel
     * @return Response
     * @throws \Exception
     */
    public function __invoke(Request $request, PhonePaginatedModel $paginatedModel): Response
    {
        $timestamp = $this->factory->build($request, $paginatedModel, null, true);
        $this->responder->buildCache($timestamp);

        if ($this->responder->isCacheValid($request) && !$this->responder->getResponse()->getContent()) {
            return $this->responder->getResponse();
        }

        return $this->responder->createResponse(
            $this->factory->build($request, $paginatedModel, self::ROUTE_NAME),
            'product_collection'
        );
    }
}
