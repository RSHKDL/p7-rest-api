<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Manager;
use App\Domain\Repository\Interfaces\Manageable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class ManagerRepository
 * @author ereshkidal
 */
final class ManagerRepository extends ServiceEntityRepository implements Manageable
{
    /**
     * ManagerRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Manager::class);
    }

    /**
     * {@inheritdoc}
     * @param Manager $entity
     */
    public function saveOrUpdate($entity, bool $update = false): void
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    /**
     * {@inheritdoc}
     * @param Manager $entity
     */
    public function remove($entity): void
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }
}
