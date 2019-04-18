<?php

namespace App\Domain\Entity\Traits;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Trait UuidTrait
 * @author ereshkidal
 */
trait UuidTrait
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * Use it in constructor
     * @throws \Exception
     */
    public function initUuid()
    {
        $this->id = Uuid::uuid4();
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }
}
