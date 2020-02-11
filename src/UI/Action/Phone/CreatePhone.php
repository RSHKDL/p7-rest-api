<?php

namespace App\UI\Action\Phone;

use App\Domain\Model\PhoneModel;
use App\UI\Factory\CreateEntityFactory;
use App\UI\Responder\CreateResponder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="You must provide this data to create a phone",
     *     required=true,
     *     @SWG\Schema(
     *         @SWG\Property(property="model", type="string", example="A new phone"),
     *         @SWG\Property(property="description", type="string", example="A description for the phone"),
     *         @SWG\Property(property="manufacturer", type="string", example="Sony"),
     *         @SWG\Property(property="price", type="float", example="199,99"),
     *         @SWG\Property(property="quantity", type="integer", example="2000"),
     *     )
     * )
     *
     * @SWG\Response(
     *      response=201,
     *      description="Phone successfully created",
     *      @SWG\Schema(ref="#/definitions/PhoneModel")
     * )
     * @SWG\Response(
     *      response=400,
     *      description="There was a validation error",
     *      @SWG\Schema(ref="#/definitions/ApiProblem")
     * )
     * @SWG\Tag(name="Phones")
     *
     * @param Request $request
     * @param CreateResponder $responder
     * @param PhoneModel $phoneModel
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @IsGranted("ROLE_ADMIN", message="Access denied. Credentials too low.")
     */
    public function __invoke(Request $request, CreateResponder $responder, PhoneModel $phoneModel): Response
    {
        $phone = $this->factory->create($request, $phoneModel);

        return $responder($phone, 'phone', 'phone_read');
    }
}
