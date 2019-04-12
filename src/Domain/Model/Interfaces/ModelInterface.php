<?php

namespace App\Domain\Model\Interfaces;

use App\Domain\Entity\Interfaces\EntityInterface;

/**
 * Interface ModelInterface
 * @author ereshkidal
 */
interface ModelInterface
{
    /**
     * @param EntityInterface $entity
     * @return ModelInterface
     * @throws \Exception
     */
    public static function createFromEntity(EntityInterface $entity): ModelInterface;

    /**
     * @return string
     */
    public function getEntityName(): string;

    /**
     * @return string
     */
    public function getEntityShortName(): string;

    /**
     * @return string
     */
    public function getId(): string;
}