<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Interfaces\EntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Manufacturer
 * @author ereshkidal
 */
class Manufacturer implements EntityInterface
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
     * @var \ArrayAccess|Phone[]
     */
    private $phones;

    /**
     * @var Collection
     */
    private $tablets;

    /**
     * Manufacturer constructor.
     *
     * @param string $name
     * @param array $phones
     * @throws \Exception
     */
    public function __construct(
        string $name,
        array $phones = [],
        array $tablets = []
    ) {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->phones = new ArrayCollection($phones);
        $this->tablets = new ArrayCollection($tablets);
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): UuidInterface
    {
        return $this->id;
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
     * @return \ArrayAccess|Phone[]
     */
    public function getPhones(): \ArrayAccess
    {
        return $this->phones;
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
     * @return Collection
     */
    public function getTablets(): Collection
    {
        return $this->tablets;
    }

    /**
     * @param Tablet $tablet
     */
    public function addTablet(Tablet $tablet): void
    {
        if (!$this->tablets->contains($tablet)) {
            $this->tablets->add($tablet);
        }
    }

    /**
     * @param Tablet $tablet
     */
    public function removeTablet(Tablet $tablet): void
    {
        if ($this->tablets->contains($tablet)) {
            $this->tablets->removeElement($tablet);
        }
    }
}
