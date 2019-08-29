<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Phone;
use App\Domain\Repository\Interfaces\Cacheable;
use App\Domain\Repository\Interfaces\Filterable;
use App\Domain\Repository\Interfaces\Manageable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class PhoneRepository
 * @author ereshkidal
 */
final class PhoneRepository extends ServiceEntityRepository implements Filterable, Cacheable, Manageable
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
     * {@inheritdoc}
     */
    public function findAllQueryBuilder(?string $filter = null, ?string $parentResourceUuid = null): ?QueryBuilder
    {
        $qb = $this
            ->createQueryBuilder('p')
            ->orderBy('p.updatedAt', 'DESC')
            ->leftJoin('p.manufacturer', 'm')
        ;

        if ($filter) {
            $qb
                ->where('p.model LIKE :filter')
                ->orWhere('p.price LIKE :filter')
                ->orWhere('m.name LIKE :filter')
                ->setParameter('filter', '%'.$filter.'%')
            ;
        }

        return $qb;
    }

    /**
     * {@inheritdoc}
     * @param Phone $entity
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
     * @param Phone $entity
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
        return $this->createQueryBuilder('p')
            ->select('p.updatedAt')
            ->where('p.id LIKE :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult(Query::HYDRATE_SINGLE_SCALAR);
    }

    /**
     * {@inheritdoc}
     */
    public function getLatestModifiedTimestampAmongAll(): ?int
    {
        return $this->createQueryBuilder('p')
            ->select('MAX(p.updatedAt) as lastUpdate')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
