<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Interfaces\EntityInterface;
use App\Domain\Entity\Traits\TimestampableTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Client
 * @author ereshkidal
 */
class Client extends AbstractUser implements EntityInterface
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
     * @Assert\Length(min="3")
     */
    private $firstName;

    /**
     * @var string
     * @Assert\Length(min="3")
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
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->initTimestampable();
    }

    /**
     * @return null|int
     */
    public function getGender(): ?int
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
     * @return null|string
     */
    public function getFirstName(): ?string
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
     * @return null|string
     */
    public function getLastName(): ?string
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
     * @return null|string
     */
    public function getPhone(): ?string
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

    /**
     * @param Retailer $retailer
     */
    public function setRetailer(Retailer $retailer): void
    {
        $this->retailer = $retailer;
    }
}
