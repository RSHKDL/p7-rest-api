<?php

namespace App\UI\Action\Phone;

use App\Domain\Model\PhoneModel;
use App\UI\Factory\CreateEntityFactory;
use App\UI\Responder\CreateResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/phones", methods={"POST"}, name="phone_create")
 *
 * Class CreatePhone
 * @author ereshkidal
 */
class CreatePhone
{
    /**
     * @var CreateEntityFactory
     */
    private $factory;

    /**
     * CreatePhone constructor.
     * @param CreateEntityFactory $factory
     */
    public function __construct(CreateEntityFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param Request $request
     * @param CreateResponder $responder
     * @param PhoneModel $phoneModel
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __invoke(Request $request, CreateResponder $responder, PhoneModel $phoneModel): Response
    {
        $phone = $this->factory->create($request, $phoneModel);

        return $responder($phone, 'phone', 'phone_read');
    }
}
