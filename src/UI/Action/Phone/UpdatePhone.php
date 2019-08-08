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
final class UpdatePhone
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
        $updatedModel = $this->factory->update($request, $model);

        return $responder($updatedModel, 'phone', 'phone_read');
    }
}
