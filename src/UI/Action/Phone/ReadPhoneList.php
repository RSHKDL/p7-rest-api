<?php

namespace App\UI\Action\Phone;

use App\Domain\Entity\Phone;
use App\Domain\Model\PhonePaginatedModel;
use App\UI\Factory\ReadEntityCollectionFactory;
use App\UI\Responder\ReadResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/phones", methods={"GET"}, name=ReadPhoneList::ROUTE_NAME)
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
     * @var ReadResponder
     */
    private $responder;

    /**
     * ReadPhoneList constructor.
     * @param ReadEntityCollectionFactory $factory
     * @param ReadResponder $responder
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
     * @throws \Exception
     */
    public function __invoke(Request $request, PhonePaginatedModel $phonePaginatedModel): Response
    {
        return $this->responder->respond(
            $this->factory->build($request, $phonePaginatedModel, self::ROUTE_NAME),
            'phone_collection'
        );
    }
}
