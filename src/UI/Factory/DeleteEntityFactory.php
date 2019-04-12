<?php

namespace App\UI\Factory;

use App\Domain\Model\Interfaces\ModelInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class DeleteEntityFactory
 * @author ereshkidal
 */
class DeleteEntityFactory
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * DeleteEntityFactory constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $id
     * @param ModelInterface $model
     */
    public function remove(string $id, ModelInterface $model): void
    {
        if (!Uuid::isValid($id)) {
            throw new BadRequestHttpException('The Uuid you provided is invalid');
        }

        $this->entityManager->getRepository($model->getEntityName())->remove($id);
    }
}
