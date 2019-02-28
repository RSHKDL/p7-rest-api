<?php

namespace App\Domain\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Phone
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var int
     */
    private $createdAt;

    /**
     * @var int
     */
    private $updatedAt;

    /**
     * @var Manufacturer
     */
    private $manufacturer;

    /**
     * @var string
     */
    private $model;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $price;

    /**
     * @var int
     */
    private $stock;

    /**
     * Phone constructor.
     *
     * @param Manufacturer $manufacturer
     * @param string $model
     * @param string $description
     * @param int $price
     * @param int $stock
     * @throws \Exception
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->createdAt = time();
        $this->updatedAt = time();
    }
}
