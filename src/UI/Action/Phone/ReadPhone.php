<?php

namespace App\UI\Action\Phone;

use App\UI\Factory\ReadPhoneFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/phones/{id}", methods={"GET"}, name="phone_read")
 *
 * Class ReadPhone
 * @package App\UI\Action\Phone
 */
class ReadPhone
{
    /**
     * @var ReadPhoneFactory
     */
    private $factory;

    /**
     * ReadPhone constructor.
     * @param ReadPhoneFactory $factory
     */
    public function __construct(ReadPhoneFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request)
    {
        return $this->factory->read($request->attributes->get('id'));
    }
}
