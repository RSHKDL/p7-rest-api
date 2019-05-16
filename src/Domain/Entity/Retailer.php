<?php

namespace App\Domain\Entity;

/**
 * Class Retailer
 * @author ereshkidal
 */
final class Retailer extends AbstractUser
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
}
