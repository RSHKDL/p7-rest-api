<?php

namespace App\Domain\Model;

use App\Domain\Entity\Interfaces\EntityInterface;
use App\Domain\Entity\Tablet;
use App\Domain\Model\Interfaces\ModelInterface;
use App\UI\Form\CreateTabletType;

/**
 * Class TabletModel
 * @author ereshkidal
 */
final class TabletModel implements ModelInterface
{
    public const ENTITY_NAME = Tablet::class;
    public const ENTITY_SHORT_NAME = 'tablet';
    public const ENTITY_TYPE = CreateTabletType::class;

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
     * @var string
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
     * @var string[]
     */
    public $_links;

    /**
     * {@inheritdoc}
     */
    public static function createFromEntity(EntityInterface $entity): ModelInterface
    {
        if (!$entity instanceof Tablet) {
            throw new \InvalidArgumentException('Invalid entity provided');
        }
        $model = new self();
        $model->id = $entity->getId();
        $model->model = $entity->getModel();
        $model->description = $entity->getDescription();
        if (null !== $entity->getManufacturer()) {
            $model->manufacturer = $entity->getManufacturer()->getName();
        }
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

    /**
     * {@inheritdoc}
     */
    public function getEntityType(): ?string
    {
        return self::ENTITY_TYPE;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function addLink(string $ref, string $url): void
    {
        $this->_links[$ref] = $url;
    }
}
