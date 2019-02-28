<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

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
}
