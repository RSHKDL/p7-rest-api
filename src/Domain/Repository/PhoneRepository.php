<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Phone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class PhoneRepository extends ServiceEntityRepository
{

    /**
     * PhoneRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Phone::class);
    }

    /**
     * @param Phone $phone
     */
    public function save(Phone $phone)
    {
        $this->_em->persist($phone);
        $this->_em->flush();
    }
}
