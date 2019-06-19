<?php

namespace App\UI\Factory;

use App\Domain\Entity\Interfaces\EntityInterface;
use App\Domain\Model\Interfaces\ModelInterface;
use App\Domain\Repository\Interfaces\Cacheable;
use App\UI\Factory\Traits\EntityGetterTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ReadEntityFactory
 * @author ereshkidal
 */
final class ReadEntityFactory
{
    use EntityGetterTrait;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * ReadEntityFactory constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Request $request
     * @param ModelInterface $model
     * @param bool $checkCache
     * @return int|ModelInterface
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Exception
     */
    public function build(Request $request, ModelInterface $model, bool $checkCache = false)
    {
        $repository = $this->entityManager->getRepository($model->getEntityName());

        if ($checkCache && $repository instanceof Cacheable) {
            $id = $request->attributes->get('id');
            $timestamp = $repository->getLatestModifiedTimestamp($id);

            if (!$timestamp) {
                throw new NotFoundHttpException(
                    sprintf('No %s found with id: %s', $model->getEntityShortName(), $id)
                );
            }

            return $timestamp;
        }

        /** @var EntityInterface $entity */
        $entity = $this->getEntity($request, $repository, $model->getEntityShortName());

        return $model::createFromEntity($entity);
    }
}
