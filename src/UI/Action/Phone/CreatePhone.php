<?php

namespace App\UI\Action\Phone;

use App\UI\Factory\CreatePhoneFactory;
use App\UI\Responder\CreateResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/phones", methods={"POST"}, name="phone_create")
 *
 * Class CreatePhone
 * @package App\UI\Action\Phone
 */
class CreatePhone
{
    /**
     * @var CreatePhoneFactory
     */
    private $factory;

    /**
     * CreatePhone constructor.
     * @param CreatePhoneFactory $factory
     */
    public function __construct(CreatePhoneFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param Request $request
     * @param CreateResponder $responder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, CreateResponder $responder)
    {
        $phone = $this->factory->create($request);

        return $responder($phone, 'phone', 'phone_read');
    }
}
