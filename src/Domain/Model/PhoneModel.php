<?php

namespace App\Domain\Model;

use App\Domain\Entity\Interfaces\EntityInterface;
use App\Domain\Entity\Manufacturer;
use App\Domain\Entity\Phone;
use App\Domain\Model\Interfaces\ModelInterface;

/**
 * Class PhoneModel
 * @author ereshkidal
 */
class PhoneModel implements ModelInterface
{
    public const ENTITY_NAME = Phone::class;
    public const ENTITY_SHORT_NAME = 'phone';

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $model;

    /**
     * @var string
     */
    public $description;

    /**
     * @var Manufacturer|null
     */
    public $manufacturer;

    /**
     * @var int
     */
    public $price;

    /**
     * @var int
     */
    public $stock;

    /**
     * {@inheritdoc}
     */
    public static function createFromEntity(EntityInterface $entity): ModelInterface
    {
        if (!$entity instanceof Phone) {
            throw new \InvalidArgumentException();
        }
        $model = new self();
        $model->id = $entity->getId();
        $model->model = $entity->getModel();
        $model->description = $entity->getDescription();
        $model->manufacturer = $entity->getManufacturer();
        $model->price = $entity->getPrice();
        $model->stock = $entity->getStock();

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityShortName(): string
    {
        return self::ENTITY_SHORT_NAME;
    }
}
