<?php

namespace App\Domain\Model;

use App\Domain\Entity\Interfaces\EntityInterface;
use App\Domain\Entity\Retailer;
use App\Domain\Model\Interfaces\ModelInterface;

/**
 * Class RetailerModel
 * @author ereshkidal
 */
final class RetailerModel implements ModelInterface
{
    public const ENTITY_NAME = Retailer::class;
    public const ENTITY_SHORT_NAME = 'retailer';

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $bic;

    /**
     * @var int
     */
    public $numberOfClients;

    /**
     * @var string[]
     */
    public $_links;

    /**
     * @param EntityInterface $entity
     * @return ModelInterface
     * @throws \Exception
     */
    public static function createFromEntity(EntityInterface $entity): ModelInterface
    {
        if (!$entity instanceof Retailer) {
            throw new \InvalidArgumentException(
                sprintf('Wrong entity: Must be %s', self::ENTITY_SHORT_NAME));
        }
        $model = new self();
        $model->id = $entity->getId();
        $model->name = $entity->getRetailerName();
        $model->email = $entity->getEmail();
        $model->bic = $entity->getBusinessIdentifierCode();
        $model->numberOfClients = $entity->getClients()->count();

        return $model;
    }

    /**
     * @return string
     */
    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    /**
     * @return string
     */
    public function getEntityShortName(): string
    {
        return self::ENTITY_SHORT_NAME;
    }

    /**
     * @return null|string
     */
    public function getEntityType(): ?string
    {
        return null;
    }

    /**
     * @return string
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
