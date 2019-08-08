<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Manufacturer;
use App\Domain\Repository\Interfaces\Filterable;
use App\Domain\Repository\Interfaces\Manageable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class ManufacturerRepository
 * @author ereshkidal
 */
final class ManufacturerRepository extends ServiceEntityRepository implements Filterable, Manageable
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
    public function findAllQueryBuilder(?string $filter = null, ?string $parentResourceUuid = null): ?QueryBuilder
    {
        return $this->createQueryBuilder('m');
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
     * {@inheritdoc}
     * @param Manufacturer $entity
     */
    public function saveOrUpdate($entity, bool $updated = false): void
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    /**
     * {@inheritdoc}
     * @param Manufacturer $entity
     */
    public function remove($entity): void
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }
}
