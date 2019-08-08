<?php

namespace App\UI\Action\Phone;

use App\Domain\Model\PhoneModel;
use App\UI\Factory\CreateEntityFactory;
use App\UI\Responder\CreateResponder;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/products/phones", methods={"POST"}, name="phone_create")
 *
 * Class CreatePhone
 * @author ereshkidal
 */
final class CreatePhone
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
     * Create a phone
     *
     * @SWG\Response(
     *      response=201,
     *      description="Phone successfully created",
     *      @Model(type=PhoneModel::class, groups={"phone"})
     * )
     * @SWG\Response(
     *      response=400,
     *      description="There was a validation error",
     *      @Model(type=App\UI\Errors\ApiProblem::class)
     * )
     * @SWG\Tag(name="Phones")
     *
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
