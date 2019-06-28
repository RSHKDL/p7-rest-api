<?php

namespace App\Domain\Entity;

use App\Application\Validation\Constraints as CustomAssert;
use App\Domain\Entity\Traits\UuidTrait;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 * @author ereshkidal
 */
abstract class AbstractUser implements UserInterface
{
    use UuidTrait;

    /**
     * @var string
     * @Assert\Email()
     * @CustomAssert\NoDuplicateClientEmail()
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var array
     */
    protected $roles;

    /**
     * User constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->initUuid();
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string The password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return array The user roles
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     */
    public function eraseCredentials(): void
    {
    }
}
