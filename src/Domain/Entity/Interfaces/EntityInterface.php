<?php

namespace App\Domain\Entity\Interfaces;

use Ramsey\Uuid\UuidInterface;

/**
 * Interface EntityInterface
 * @author ereshkidal
 */
interface EntityInterface
{
    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface;
}
