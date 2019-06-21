<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Interfaces\EntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class Retailer
 * @author ereshkidal
 */
class Retailer extends AbstractUser implements EntityInterface
{
    /**
     * @var string
     */
    private $retailerName;

    /**
     * @var string
     */
    private $businessIdentifierCode;

    /**
     * @var Collection
     */
    private $clients;

    /**
     * Retailer constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->clients = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getRetailerName(): string
    {
        return $this->retailerName;
    }

    /**
     * @param string $retailerName
     */
    public function setRetailerName(string $retailerName): void
    {
        $this->retailerName = $retailerName;
    }

    /**
     * @return string
     */
    public function getBusinessIdentifierCode(): string
    {
        return $this->businessIdentifierCode;
    }

    /**
     * @param string $businessIdentifierCode
     */
    public function setBusinessIdentifierCode(string $businessIdentifierCode): void
    {
        $this->businessIdentifierCode = $businessIdentifierCode;
    }

    /**
     * @param Collection $clients
     * @return Retailer
     */
    public function setClients(Collection $clients): Retailer
    {
        $this->clients = $clients;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }
}
