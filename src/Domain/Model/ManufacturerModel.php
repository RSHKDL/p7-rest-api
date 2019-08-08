<?php

namespace App\Domain\Model;

use App\Domain\Entity\Interfaces\EntityInterface;
use App\Domain\Entity\Manufacturer;
use App\Domain\Entity\Phone;
use App\Domain\Entity\Tablet;
use App\Domain\Model\Interfaces\ModelInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class ManufacturerModel
 * @author ereshkidal
 */
final class ManufacturerModel implements ModelInterface
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
     * @var Collection
     * @SWG\Property(ref=@Model(type=PhoneModel::class))
     */
    public $phones;

    /**
     * @var Collection
     * @SWG\Property(ref=@Model(type=TabletModel::class))
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
            throw new \InvalidArgumentException('Invalid entity provided');
        }

        $model = new self();
        $model->id = $entity->getId();
        $model->name = $entity->getName();
        $model->phones = $model->createModelsFromEntities($entity->getPhones());
        $model->tablets = $model->createModelsFromEntities($entity->getTablets());
        $model->numberOfPhones = $model->phones->count();
        $model->numberOfTablets = $model->tablets->count();

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

    /**
     * {@inheritdoc}
     */
    public function addLink(string $ref, string $url): void
    {

    }

    /**
     * @param Collection $entities
     * @return ArrayCollection
     * @throws \Exception
     */
    private function createModelsFromEntities(Collection $entities): ArrayCollection
    {
        $models = new ArrayCollection();
        foreach ($entities as $entity) {
            if ($entity instanceof Phone) {
                $models->add(PhoneModel::createFromEntity($entity));
            }
            if ($entity instanceof Tablet) {
                $models->add(TabletModel::createFromEntity($entity));
            }
        }

        return $models;
    }
}
