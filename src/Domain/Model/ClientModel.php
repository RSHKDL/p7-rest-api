<?php

namespace App\Domain\Model;

use App\Domain\Entity\Client;
use App\Domain\Entity\Interfaces\EntityInterface;
use App\Domain\Model\Interfaces\ModelInterface;
use App\UI\Form\CreateClientType;

/**
 * Class ClientModel
 * @author ereshkidal
 */
final class ClientModel implements ModelInterface
{
    public const ENTITY_NAME = Client::class;
    public const ENTITY_SHORT_NAME = 'client';
    public const ENTITY_TYPE = CreateClientType::class;

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $retailerId;

    /**
     * @var int
     */
    public $gender;

    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $lastName;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $phone;

    /**
     * {@inheritdoc}
     */
    public static function createFromEntity(EntityInterface $entity): ModelInterface
    {
        if (!$entity instanceof Client) {
            throw new \InvalidArgumentException('Invalid entity provided');
        }
        $dto = new self();
        $dto->id = $entity->getId();
        $dto->retailerId = $entity->getRetailer()->getId();
        $dto->gender = $entity->getGender();
        $dto->firstName = $entity->getFirstName();
        $dto->lastName = $entity->getLastName();
        $dto->email = $entity->getEmail();
        $dto->phone = $entity->getPhone();

        return $dto;
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
     * @return string|null
     */
    public function getEntityType(): ?string
    {
        return self::ENTITY_TYPE;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getParentId(): ?string
    {
        return $this->retailerId;
    }
}
