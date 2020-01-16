<?php

namespace App\UI\Action\Tablet;

use App\Domain\Model\TabletModel;
use App\UI\Factory\DeleteEntityFactory;
use App\UI\Responder\DeleteResponder;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/products/tablets/{id}", methods={"DELETE"}, name="tablet_delete")
 *
 * Class DeleteTablet
 * @author ereshkidal
 */
final class DeleteTablet
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
     * Delete a tablet
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="Must be a valid version 4 Uuid"
     * )
     * @SWG\Response(
     *      response=204,
     *      description="Tablet successfully deleted / Tablet not found"
     * )
     * @SWG\Tag(name="Tablets")
     *
     * @param Request $request
     * @param DeleteResponder $responder
     * @param TabletModel $model
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __invoke(Request $request, DeleteResponder $responder, TabletModel $model): Response
    {
        $this->factory->remove($request, $model);

        return $responder();
    }
}
