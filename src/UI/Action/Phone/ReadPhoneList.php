<?php

namespace App\UI\Action\Phone;

use App\UI\Factory\ReadPhoneListFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/phones", methods={"GET"}, name="phone_read_collection")
 *
 * Class ReadPhoneList
 * @author ereshkidal
 */
class ReadPhoneList
{
    /**
     * @var ReadPhoneListFactory
     */
    private $factory;

    /**
     * ReadPhoneList constructor.
     * @param ReadPhoneListFactory $factory
     */
    public function __construct(ReadPhoneListFactory $factory)
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
