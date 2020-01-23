<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Interfaces\EntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Manager
 * @author ereshkidal
 * @ORM\Entity()
 */
class Manager extends AbstractUser implements EntityInterface
{

}
