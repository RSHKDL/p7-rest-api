<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Retailer;
use App\Domain\Repository\Interfaces\Manageable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class RetailerRepository
 * @author ereshkidal
 */
class RetailerRepository extends ServiceEntityRepository implements Manageable
{
    /**
     * RetailerRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Retailer::class);
    }

    /**
     * $entity MUST be a valid Entity
     *
     * @param mixed $entity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save($entity): void
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    /**
     * $entity MUST be a valid Entity
     *
     * @param mixed $entity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update($entity): void
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    /**
     * @param string $id
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(string $id): bool
    {
        $retailer = $this->find($id);
        if (null === $retailer) {
            return false;
        }
        $this->_em->remove($retailer);
        $this->_em->flush();

        return true;
    }
}
