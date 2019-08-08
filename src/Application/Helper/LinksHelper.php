<?php

namespace App\Application\Helper;

use App\Domain\Model\ClientModel;
use App\Domain\Model\Interfaces\ModelInterface;
use App\Domain\Model\Interfaces\PaginatedModelInterface;
use App\Domain\Model\RetailerModel;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @todo all this stuff might be better as an event
 * Class LinksHelper
 * @author ereshkidal
 */
final class LinksHelper
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * LinksHelper constructor.
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param PaginatedModelInterface $paginatedModel
     */
    public function addLinks(PaginatedModelInterface $paginatedModel): void
    {
        /** @var ModelInterface $model */
        foreach ($paginatedModel->getModels() as $model) {
            $routeName = $model->getEntityShortName() . '_read';
            $params = ['id' => $model->getId()];
            if ($model instanceof ClientModel) {
                $params = [
                    'retailerUuid' => $model->getParentId(),
                    'clientUuid' => $model->getId()
                ];
            }
            $model->addLink('self', $this->urlGenerator->generate($routeName, $params));
        }
    }

    /**
     * @param ModelInterface $model
     */
    public function addLink(ModelInterface $model): void
    {
        if ($model instanceof RetailerModel) {
            return;
        }
        $routeName = $model->getEntityShortName() . '_read_collection';
        $params =[];
        if ($model instanceof ClientModel) {
            $params = ['retailerUuid' => $model->retailerId];
        }
        $model->addLink('collection', $this->urlGenerator->generate($routeName, $params));
    }
}
