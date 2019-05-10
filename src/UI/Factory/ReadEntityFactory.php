<?php

namespace App\UI\Factory;

use App\Domain\Entity\Interfaces\EntityInterface;
use App\Domain\Model\Interfaces\ModelInterface;
use App\Domain\Repository\Interfaces\Cacheable;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class ReadEntityFactory
 * @author ereshkidal
 */
class ReadEntityFactory
{
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
     * @param string $id
     * @param ModelInterface $model
     * @param bool $checkCache
     * @return int|ModelInterface
     * @throws \Exception
     */
    public function build(string $id, ModelInterface $model, bool $checkCache = false)
    {
        if (!Uuid::isValid($id)) {
            throw new BadRequestHttpException('The Uuid you provided is invalid');
        }

        $repository = $this->entityManager->getRepository($model->getEntityName());

        if ($checkCache && $repository instanceof Cacheable) {
            $timestamp = $repository->getLatestModifiedTimestamp($id);

            if (!$timestamp) {
                throw new NotFoundHttpException(
                    sprintf('No %s found with id: %s', $model->getEntityShortName(), $id)
                );
            }

            return $timestamp;
        }

        $entity = $repository->find($id);

        //@todo is this check really necessary ?
        if (!$entity instanceof EntityInterface) {
            throw new UnprocessableEntityHttpException(
                'This entity does not implement EntityInterface'
            );
        }

        return $model::createFromEntity($entity);
    }
}
