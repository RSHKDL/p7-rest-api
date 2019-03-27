<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Phone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

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
     * @return QueryBuilder
     */
    public function findAllQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('phone');
    }

    /**
     * @param Phone $phone
     */
    public function save(Phone $phone)
    {
        $this->_em->persist($phone);
        $this->_em->flush();
    }

    /**
     * @param string $id
     * @return bool
     */
    public function remove(string $id)
    {
        $phone = $this->find($id);
        if (null === $phone) {
            return false;
        }
        $this->_em->remove($phone);
        $this->_em->flush();

        return true;
    }
}
