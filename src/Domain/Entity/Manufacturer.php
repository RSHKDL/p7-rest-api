<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Manufacturer
 * @author ereshkidal
 */
class Manufacturer
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var ArrayCollection
     */
    private $phones;

    /**
     * Manufacturer constructor.
     *
     * @param string $name
     * @param array $phones
     * @throws \Exception
     */
    public function __construct(
        string $name,
        array $phones = []
    ) {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->phones = new ArrayCollection($phones);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param Phone $phone
     */
    public function addPhone(Phone $phone): void
    {
        if (!$this->phones->contains($phone)) {
            $this->phones->add($phone);
        }
    }
    /**
     * @param Phone $phone
     */
    public function removePhone(Phone $phone): void
    {
        if ($this->phones->contains($phone)) {
            $this->phones->removeElement($phone);
        }
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }
}
