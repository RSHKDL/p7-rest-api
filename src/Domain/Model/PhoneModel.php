<?php

namespace App\Domain\Model;

use App\Domain\Entity\Interfaces\EntityInterface;
use App\Domain\Entity\Manufacturer;
use App\Domain\Entity\Phone;
use App\Domain\Model\Interfaces\ModelInterface;
use App\UI\Form\CreatePhoneType;
use Swagger\Annotations as SWG;

/**
 * Class PhoneModel
 * @author ereshkidal
 */
final class PhoneModel implements ModelInterface
{
    public const ENTITY_NAME = Phone::class;
    public const ENTITY_SHORT_NAME = 'phone';
    public const ENTITY_TYPE = CreatePhoneType::class;

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
     * @var string
     */
    public $lastModified;

    /**
     * @var string[]
     */
    public $_links;

    /**
     * {@inheritdoc}
     */
    public static function createFromEntity(EntityInterface $entity): ModelInterface
    {
        if (!$entity instanceof Phone) {
            throw new \InvalidArgumentException('Invalid entity provided');
        }
        $model = new self();
        $model->id = $entity->getId();
        $model->model = $entity->getModel();
        $model->description = $entity->getDescription();
        $model->manufacturer = $entity->getManufacturer();
        $model->price = $entity->getPrice();
        $model->stock = $entity->getStock();
        $model->lastModified = self::formatDateFromTimestamp($entity->getUpdatedAt());

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

    /**
     * @param int $timestamp
     * @return string
     * @throws \Exception
     */
    private static function formatDateFromTimestamp(int $timestamp): string
    {
        $date = new \DateTime();

        return $date->setTimestamp($timestamp)->format('m/d/Y h:i');
    }
}
