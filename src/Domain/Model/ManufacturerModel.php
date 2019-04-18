<?php

namespace App\Domain\Model;

use App\Domain\Entity\Interfaces\EntityInterface;
use App\Domain\Entity\Manufacturer;
use App\Domain\Entity\Phone;
use App\Domain\Entity\Tablet;
use App\Domain\Model\Interfaces\ModelInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ManufacturerModel
 * @author ereshkidal
 */
class ManufacturerModel implements ModelInterface
{
    public const ENTITY_NAME = Manufacturer::class;
    public const ENTITY_SHORT_NAME = 'manufacturer';

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var \ArrayAccess|Phone[]
     */
    public $phones;

    /**
     * @var
     */
    public $tablets;

    /**
     * @var int
     */
    public $numberOfPhones;

    /**
     * @var int
     */
    public $numberOfTablets;

    /**
     * {@inheritdoc}
     */
    public static function createFromEntity(EntityInterface $entity): ModelInterface
    {
        if (!$entity instanceof Manufacturer) {
            throw new \InvalidArgumentException();
        }

        $model = new self();
        $model->id = $entity->getId();
        $model->name = $entity->getName();
        $model->phones = $entity->getPhones();
        $model->tablets = $entity->getTablets();
        $model->numberOfPhones = count($model->phones);
        $model->numberOfTablets = count($model->tablets);

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

    /**
     * {@inheritdoc}
     */
    public function getEntityType(): ?string
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return $this->id;
    }
}
