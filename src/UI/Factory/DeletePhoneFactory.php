<?php

namespace App\UI\Factory;

use App\Domain\Repository\PhoneRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class DeletePhoneFactory
 * @author ereshkidal
 */
class DeletePhoneFactory
{
    /**
     * @var PhoneRepository
     */
    private $repository;

    /**
     * DeletePhoneFactory constructor.
     * @param PhoneRepository $repository
     */
    public function __construct(
        PhoneRepository $repository
    ) {
        $this->repository = $repository;
    }

    /**
     * @param string $id
     */
    public function remove(string $id): void
    {
        if (!$this->repository->remove($id)) {
            throw new NotFoundHttpException(sprintf('Phone not found with id %s', $id));
        }
    }
}
