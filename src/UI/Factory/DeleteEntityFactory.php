<?php

namespace App\UI\Factory;

use App\Domain\Model\Interfaces\ModelInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     */
    public function remove(string $id, ModelInterface $model): void
    {
        if (!$this->entityManager->getRepository($model->getEntityName())->remove($id)) {
            throw new NotFoundHttpException(sprintf(
                '%s not found with id %s',
                $model->getEntityShortName(),
                $id
            ));
        }
    }
}
