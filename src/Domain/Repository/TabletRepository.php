<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Tablet;
use App\Domain\Repository\Interfaces\Cacheable;
use App\Domain\Repository\Interfaces\Manageable;
use App\Domain\Repository\Interfaces\Queryable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class TabletRepository
 * @author ereshkidal
 */
final class TabletRepository extends ServiceEntityRepository implements Queryable, Cacheable, Manageable
{
    /**
     * TabletRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tablet::class);
    }

    /**
     * {@inheritdoc}
     */
    public function findAllQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('tablet');
    }

    /**
     * {@inheritdoc}
     */
    public function findAllByRetailerQueryBuilder(string $retailerUuid): ?QueryBuilder
    {
        return null;
    }

    /**
     * {@inheritdoc}
     * @param Tablet $entity
     */
    public function saveOrUpdate($entity, bool $updated = false): void
    {
        if ($updated) {
            $entity->setUpdatedAt(time());
        }
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    /**
     * {@inheritdoc}
     * @param Tablet $entity
     */
    public function remove($entity): void
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getLatestModifiedTimestamp(string $id): ?int
    {
        return $this->createQueryBuilder('t')
            ->select('t.updatedAt')
            ->where('t.id LIKE :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult(Query::HYDRATE_SINGLE_SCALAR);
    }

    /**
     * {@inheritdoc}
     */
    public function getLatestModifiedTimestampAmongAll(): ?int
    {
        return $this->createQueryBuilder('t')
            ->select('MAX(t.updatedAt) as lastUpdate')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
