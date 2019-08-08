<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Tablet;
use App\Domain\Repository\Interfaces\Cacheable;
use App\Domain\Repository\Interfaces\Filterable;
use App\Domain\Repository\Interfaces\Manageable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class TabletRepository
 * @author ereshkidal
 */
final class TabletRepository extends ServiceEntityRepository implements Filterable, Cacheable, Manageable
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

    /**
     * {@inheritdoc}
     */
    public function findAllQueryBuilder(?string $filter = null, ?string $parentResourceUuid = null): ?QueryBuilder
    {
        $qb = $this
            ->createQueryBuilder('t')
            ->orderBy('t.updatedAt', 'DESC')
            ->leftJoin('t.manufacturer', 'm')
        ;

        if ($filter) {
            $qb
                ->where('t.model LIKE :filter')
                ->orWhere('t.price LIKE :filter')
                ->orWhere('m.name LIKE :filter')
                ->setParameter('filter', '%'.$filter.'%')
            ;
        }

        return $qb;
    }
}
