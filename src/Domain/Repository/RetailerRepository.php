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
final class RetailerRepository extends ServiceEntityRepository implements Manageable
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
     * {@inheritdoc}
     * @param Retailer $entity
     */
    public function saveOrUpdate($entity, bool $updated = false): void
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    /**
     * {@inheritdoc}
     * @param Retailer $entity
     */
    public function remove($entity): void
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }
}
