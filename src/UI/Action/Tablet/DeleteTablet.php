<?php

namespace App\UI\Action\Tablet;

use App\Domain\Model\TabletModel;
use App\UI\Factory\DeleteEntityFactory;
use App\UI\Responder\DeleteResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/products/tablets/{id}", methods={"DELETE"}, name="tablet_delete")
 *
 * Class DeleteTablet
 * @author ereshkidal
 */
class DeleteTablet
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
     * @param TabletModel $model
     * @return Response
     */
    public function __invoke(Request $request, DeleteResponder $responder, TabletModel $model): Response
    {
        $this->factory->remove($request->attributes->get('id'), $model);

        return $responder();
    }
}
