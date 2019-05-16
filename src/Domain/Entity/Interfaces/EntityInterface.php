<?php

namespace App\Domain\Entity\Interfaces;

use Ramsey\Uuid\UuidInterface;

/**
 * @todo change name to Modelizable
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
