<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Manufacturer;
use App\Domain\Repository\Interfaces\Queryable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class ManufacturerRepository
 * @author ereshkidal
 */
class ManufacturerRepository extends ServiceEntityRepository implements Queryable
{
    /**
     * ManufacturerRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Manufacturer::class);
    }

    /**
     * {@inheritdoc}
     */
    public function findAllQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('manufacturer');
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByName(string $name)
    {
        return $this->createQueryBuilder('m')
            ->where('m.name LIKE :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param Manufacturer $manufacturer
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Manufacturer $manufacturer): void
    {
        $this->_em->persist($manufacturer);
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
        // TODO: Implement remove() method.
    }
}
