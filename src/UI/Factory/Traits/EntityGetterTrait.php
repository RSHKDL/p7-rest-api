<?php

namespace App\UI\Factory\Traits;

use App\Domain\Repository\ClientRepository;
use App\Domain\Repository\RetailerRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Trait EntityGetterTrait
 * @author ereshkidal
 */
trait EntityGetterTrait
{
    /**
     * @param Request $request
     * @param ObjectRepository $repository
     * @return object|null
     */
    protected function getEntity(Request $request, ObjectRepository $repository)
    {
        if ($repository instanceof ClientRepository) {
            return $repository->findOneBy([
                'id' => $request->attributes->get('clientUuid'),
                'retailer' => $request->attributes->get('retailerUuid')
            ]);
        }

        if ($repository instanceof RetailerRepository) {
            return $repository->find($request->attributes->get('retailerUuid'));
        }

        return $repository->find($request->attributes->get('id'));
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
