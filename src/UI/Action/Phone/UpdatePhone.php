<?php

namespace App\UI\Action\Phone;

use App\Domain\Model\PhoneModel;
use App\UI\Factory\UpdateEntityFactory;
use App\UI\Responder\UpdateResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/products/phones/{id}", methods={"PUT", "PATCH"}, name="phone_update")
 *
 * Class UpdatePhone
 * @author ereshkidal
 */
class UpdatePhone
{
    /**
     * @var UpdateEntityFactory
     */
    private $factory;

    /**
     * UpdatePhone constructor.
     * @param UpdateEntityFactory $factory
     */
    public function __construct(UpdateEntityFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param Request $request
     * @param UpdateResponder $responder
     * @param PhoneModel $model
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function __invoke(Request $request, UpdateResponder $responder, PhoneModel $model)
    {
        $phone = $this->factory->update($request, $request->attributes->get('id'), $model);

        return $responder($phone, 'phone', 'phone_read');
    }
}
