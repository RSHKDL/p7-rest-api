<?php

namespace App\Domain\Model;

use App\Domain\Entity\Interfaces\EntityInterface;
use App\Domain\Model\Interfaces\ModelInterface;

/**
 * Class RetailerModel
 * @author ereshkidal
 */
class RetailerModel implements ModelInterface
{
    /**
     * @param EntityInterface $entity
     * @return ModelInterface
     * @throws \Exception
     */
    public static function createFromEntity(EntityInterface $entity): ModelInterface
    {
        // TODO: Implement createFromEntity() method.
    }

    /**
     * @return string
     */
    public function getEntityName(): string
    {
        // TODO: Implement getEntityName() method.
    }

    /**
     * @return string
     */
    public function getEntityShortName(): string
    {
        // TODO: Implement getEntityShortName() method.
    }

    /**
     * @return null|string
     */
    public function getEntityType(): ?string
    {
        // TODO: Implement getEntityType() method.
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        // TODO: Implement getId() method.
    }
}
