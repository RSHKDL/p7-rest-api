<?php

namespace App\Domain\Model\Traits;

use App\Domain\Model\Interfaces\ModelInterface;

/**
 * Trait CreateModelsFromEntitiesTrait
 * @author ereshkidal
 */
trait CreateModelsFromEntitiesTrait
{
    /**
     * @param array $entities
     * @param ModelInterface $model
     * @return array
     * @throws \Exception
     */
    public function createModelsFromEntities(array $entities, ModelInterface $model): array
    {
        $models = [];
        foreach ($entities as $entity) {
            $models[] = $model::createFromEntity($entity);
        }

        return $models;
    }
}
