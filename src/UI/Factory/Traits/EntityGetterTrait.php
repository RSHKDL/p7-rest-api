<?php

namespace App\UI\Factory\Traits;

use App\Domain\Repository\ClientRepository;
use App\Domain\Repository\Interfaces\Cacheable;
use App\Domain\Repository\ManufacturerRepository;
use App\Domain\Repository\RetailerRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @todo this nice trait does not work with the actual caching setup :(
 * Trait EntityGetterTrait
 * @author ereshkidal
 */
trait EntityGetterTrait
{
    /**
     * @param Request $request
     * @param ObjectRepository $repository
     * @param string|null $entityName
     * @return object|null
     */
    protected function getEntity(Request $request, ObjectRepository $repository, ?string $entityName)
    {
        $entity = null;
        $id = 'not defined';

        if ($repository instanceof ClientRepository) {
            $id = $request->attributes->get('clientUuid');
            $this->validateUuid($id);
            $entity = $repository->findOneBy([
                'id' => $id,
                'retailer' => $request->attributes->get('retailerUuid')
            ]);
        }

        if ($repository instanceof RetailerRepository) {
            $id = $request->attributes->get('retailerUuid');
            $this->validateUuid($id);
            $entity = $repository->find($id);
        }

        if ($repository instanceof ManufacturerRepository) {
            $id = $request->attributes->get('manufacturerUuid');
            $this->validateUuid($id);
            $entity = $repository->find($id);
        }

        // only products are cacheable for now
        if ($repository instanceof Cacheable) {
            $id = $request->attributes->get('id');
            $this->validateUuid($id);
            $entity = $repository->find($id);
        }

        if (!$entity && $request->getMethod() !== Request::METHOD_DELETE) {
            throw new NotFoundHttpException(
                sprintf('No %s found with id: %s', $entityName, $id)
            );
        }

        return $entity;
    }

    /**
     * @param string $uuid
     * @return string
     */
    private function validateUuid(string $uuid): string
    {
        if (!Uuid::isValid($uuid)) {
            throw new BadRequestHttpException('The Uuid you provided is invalid');
        }

        return $uuid;
    }
}
