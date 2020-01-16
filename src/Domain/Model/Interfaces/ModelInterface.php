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
     * @todo rename to getFormType
     * @return null|string
     */
    public function getEntityType(): ?string;

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @param string $ref
     * @param string $url
     */
    public function addLink(string $ref, string $url): void;
}
