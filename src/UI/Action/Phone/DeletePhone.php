<?php

namespace App\UI\Action\Phone;

use App\UI\Factory\DeletePhoneFactory;
use App\UI\Responder\DeleteResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/phones/{id}", methods={"DELETE"}, name="phone_delete")
 *
 * Class DeletePhone
 * @author ereshkidal
 */
class DeletePhone
{
    /**
     * @var DeletePhoneFactory
     */
    private $factory;

    /**
     * DeletePhone constructor.
     * @param DeletePhoneFactory $factory
     */
    public function __construct(DeletePhoneFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param Request $request
     * @param DeleteResponder $responder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, DeleteResponder $responder)
    {
        $this->factory->remove($request->attributes->get('id'));

        return $responder();
    }
}
