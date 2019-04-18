<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Interfaces\EntityInterface;
use App\Domain\Entity\Traits\TimestampableTrait;
use App\Domain\Entity\Traits\UuidTrait;

/**
 * Class Phone
 * @author ereshkidal
 */
final class Phone extends AbstractProduct implements EntityInterface
{
    use UuidTrait;
    use TimestampableTrait;

    /**
     * @var Manufacturer
     */
    private $manufacturer;

    /**
     * @var string
     */
    private $model;

    /**
     * Phone constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->initUuid();
        $this->initTimestampable();
    }

    /**
     * @return null|Manufacturer
     */
    public function getManufacturer(): ?Manufacturer
    {
        return $this->manufacturer;
    }

    /**
     * @param Manufacturer $manufacturer
     */
    public function setManufacturer(Manufacturer $manufacturer): void
    {
        $this->manufacturer = $manufacturer;
    }

    /**
     * @return null|string
     */
    public function getModel(): ?string
    {
        return $this->model;
    }

    /**
     * @param string $model
     */
    public function setModel(string $model): void
    {
        $this->model = $model;
    }
}
