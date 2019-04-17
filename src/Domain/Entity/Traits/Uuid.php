<?php

namespace App\Domain\Entity\Traits;

use Ramsey\Uuid\Uuid as RamseyUuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Trait Uuid
 * @author ereshkidal
 */
trait Uuid
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
        $this->id = RamseyUuid::uuid4();
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }
}
