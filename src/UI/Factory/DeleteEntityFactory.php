<?php

namespace App\UI\Factory;

use App\Domain\Model\Interfaces\ModelInterface;
use App\Domain\Repository\Interfaces\Manageable;
use App\UI\Factory\Traits\EntityGetterTrait;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DeleteEntityFactory
 * @author ereshkidal
 */
final class DeleteEntityFactory
{
    use EntityGetterTrait;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * DeleteEntityFactory constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Request $request
     * @param ModelInterface $model
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(Request $request, ModelInterface $model): void
    {
        /** @var ObjectRepository|Manageable $repository */
        $repository = $this->entityManager->getRepository($model->getEntityName());
        $entity = $this->getEntity($request, $repository, $model->getEntityShortName());
        if ($entity) {
            $repository->remove($entity);
        }
    }
}
