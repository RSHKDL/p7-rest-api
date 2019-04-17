<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Interfaces\EntityInterface;
use App\Domain\Entity\Traits\Timestampable;
use App\Domain\Entity\Traits\Uuid;

/**
 * Class Tablet
 * @author ereshkidal
 */
class Tablet implements EntityInterface
{
    use Uuid;
    use Timestampable;

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
     * Tablet constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->initUuid();
        $this->initTimestampable();
    }
}
