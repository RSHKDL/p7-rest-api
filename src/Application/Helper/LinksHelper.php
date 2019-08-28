<?php

namespace App\Application\Helper;

use App\Domain\Model\ClientModel;
use App\Domain\Model\Interfaces\ModelInterface;
use App\Domain\Model\Interfaces\PaginatedModelInterface;
use App\Domain\Model\ManufacturerModel;
use App\Domain\Model\PhoneModel;
use App\Domain\Model\RetailerModel;
use App\Domain\Model\TabletModel;
use App\UI\Action\Retailer\ReadRetailerClientList;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @todo This is totally against the open-close principle :(
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
            if ($model instanceof ManufacturerModel) {
                $params = ['manufacturerUuid' => $model->getId()];
            }
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
        $params =[];
        $readCollectionRoute = $model->getEntityShortName() . '_read_collection';
        if ($model instanceof RetailerModel) {
            $params = ['retailerUuid' => $model->getId()];
            $model->addLink('add_client', $this->urlGenerator->generate('client_create', $params));
            $model->addLink('show_clients', $this->urlGenerator->generate(ReadRetailerClientList::ROUTE_NAME, $params));

            return;
        }
        if ($model instanceof ClientModel) {
            $params = ['retailerUuid' => $model->retailerId];
            $model->addLink('client_collection', $this->urlGenerator->generate($readCollectionRoute, $params));
            $params['clientUuid'] = $model->getId();
            $model->addLink('client_update', $this->urlGenerator->generate('client_update', $params));
            $model->addLink('client_delete', $this->urlGenerator->generate('client_delete', $params));

            return;
        }
        if ($model instanceof PhoneModel) {
            $model->addLink('phone_collection', $this->urlGenerator->generate($readCollectionRoute, $params));
            $params['id'] = $model->getId();
            $model->addLink('phone_update', $this->urlGenerator->generate('phone_update', $params));
            $model->addLink('phone_delete', $this->urlGenerator->generate('phone_delete', $params));

            return;
        }
        if ($model instanceof TabletModel) {
            $model->addLink('tablet_collection', $this->urlGenerator->generate($readCollectionRoute, $params));
            $params['id'] = $model->getId();
            $model->addLink('tablet_update', $this->urlGenerator->generate('tablet_update', $params));
            $model->addLink('tablet_delete', $this->urlGenerator->generate('tablet_delete', $params));

            return;
        }
        if ($model instanceof ManufacturerModel) {
            $model->addLink('manufacturer_collection', $this->urlGenerator->generate($readCollectionRoute, $params));

            return;
        }
    }
}
