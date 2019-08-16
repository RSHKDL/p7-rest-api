<?php

namespace App\UI\Action\Phone;

use App\Domain\Model\PhoneModel;
use App\UI\Factory\DeleteEntityFactory;
use App\UI\Responder\DeleteResponder;
use Swagger\Annotations as SWG;
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
     * Delete a phone
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="Must be a valid version 4 Uuid"
     * )
     * @SWG\Response(
     *      response=204,
     *      description="Phone successfully deleted / Phone not found"
     * )
     * @SWG\Tag(name="Phones")
     * 
     * @param Request $request
     * @param DeleteResponder $responder
     * @param PhoneModel $model
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __invoke(Request $request, DeleteResponder $responder, PhoneModel $model): Response
    {
        $this->factory->remove($request, $model);

        return $responder();
    }
}
