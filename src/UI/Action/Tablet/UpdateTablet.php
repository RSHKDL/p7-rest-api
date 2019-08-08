<?php

namespace App\UI\Action\Tablet;

use App\Domain\Model\TabletModel;
use App\UI\Factory\UpdateEntityFactory;
use App\UI\Responder\UpdateResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/products/tablets/{id}", methods={"PUT", "PATCH"}, name="tablet_update")
 *
 * Class UpdateTablet
 * @author ereshkidal
 */
final class UpdateTablet
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
     * @param TabletModel $model
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function __invoke(Request $request, UpdateResponder $responder, TabletModel $model)
    {
        $updatedModel = $this->factory->update($request, $model);

        return $responder($updatedModel, 'tablet', 'tablet_read');
    }
}
