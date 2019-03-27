<?php

namespace App\UI\Action\Phone;

use App\UI\Factory\ReadPhoneListFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/phones", methods={"GET"}, name="phone_read_collection")
 *
 * Class ReadPhoneList
 * @package App\UI\Action\Phone
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request)
    {
        return $this->factory->read($request);
    }
}
