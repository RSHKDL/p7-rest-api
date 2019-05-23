<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Traits\TimestampableTrait;

/**
 * Class Client
 * @author ereshkidal
 */
final class Client extends AbstractUser
{
    use TimestampableTrait;

    private const GENDER_OTHER = 0;
    private const GENDER_FEMALE = 1;
    private const GENDER_MALE = 2;

    /**
     * @var int
     */
    private $gender;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var Retailer
     */
    private $retailer;

    /**
     * Client constructor.
     * @param Retailer $retailer
     * @throws \Exception
     */
    public function __construct(Retailer $retailer)
    {
        parent::__construct();
        $this->retailer = $retailer;
    }

    /**
     * @return int
     */
    public function getGender(): int
    {
        return $this->gender;
    }

    /**
     * @param int $gender
     */
    public function setGender(int $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return Retailer
     */
    public function getRetailer(): Retailer
    {
        return $this->retailer;
    }
}
