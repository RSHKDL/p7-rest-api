<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Interfaces\EntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Retailer
 * @author ereshkidal
 * @ORM\Entity()
 * @UniqueEntity(fields={"email"}, groups={"createRetailer"})
 * @UniqueEntity(fields={"retailerName"}, groups={"createRetailer"})
 */
class Retailer extends AbstractUser implements EntityInterface
{
    /**
     * @var string
     * @Assert\NotBlank(groups={"createRetailer"})
     */
    private $retailerName;

    /**
     * @var string
     * @Assert\NotBlank(groups={"createRetailer"})
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
