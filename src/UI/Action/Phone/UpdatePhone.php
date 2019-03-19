<?php

namespace App\UI\Action\Phone;

use App\UI\Factory\UpdatePhoneFactory;
use App\UI\Responder\UpdateResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/phones/{id}", methods={"PUT", "PATCH"}, name="phone_update")
 *
 * Class UpdatePhone
 * @author ereshkidal
 */
class UpdatePhone
{
    /**
     * @var UpdatePhoneFactory
     */
    private $factory;

    /**
     * UpdatePhone constructor.
     * @param UpdatePhoneFactory $factory
     */
    public function __construct(UpdatePhoneFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param Request $request
     * @param UpdateResponder $responder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, UpdateResponder $responder)
    {
        $phone = $this->factory->update($request, $request->attributes->get('id'));

        return $responder($phone, 'phone', 'phone_read');
    }
}
