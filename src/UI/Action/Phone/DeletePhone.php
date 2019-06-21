<?php

namespace App\UI\Action\Phone;

use App\Domain\Model\PhoneModel;
use App\UI\Factory\DeleteEntityFactory;
use App\UI\Responder\DeleteResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/products/phones/{id}", methods={"DELETE"}, name="phone_delete")
 *
 * Class DeletePhone
 * @author ereshkidal
 */
final class DeletePhone
{
    /**
     * @var DeleteEntityFactory
     */
    private $factory;

    /**
     * DeletePhone constructor.
     * @param DeleteEntityFactory $factory
     */
    public function __construct(DeleteEntityFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param Request $request
     * @param DeleteResponder $responder
     * @param PhoneModel $model
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __invoke(Request $request, DeleteResponder $responder, PhoneModel $model): Response
    {
        $this->factory->remove($request->attributes->get('id'), $model);

        return $responder();
    }
}
