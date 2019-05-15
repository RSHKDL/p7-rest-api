<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Phone;
use App\Domain\Repository\Interfaces\Cacheable;
use App\Domain\Repository\Interfaces\Manageable;
use App\Domain\Repository\Interfaces\Queryable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class PhoneRepository
 * @author ereshkidal
 */
class PhoneRepository extends ServiceEntityRepository implements Queryable, Cacheable, Manageable
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
    public function findAllQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.updatedAt', 'DESC');
    }

    /**
     * {@inheritdoc}
     * @param Phone $entity
     */
    public function save($entity): void
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    /**
     * {@inheritdoc}
     * @param Phone $entity
     */
    public function update($entity): void
    {
        $entity->setUpdatedAt(time());
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function remove(string $id): bool
    {
        $phone = $this->find($id);
        if (null === $phone) {
            return false;
        }
        $this->_em->remove($phone);
        $this->_em->flush();

        return true;
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
    public function getLatestModifiedTimestampAmongAll(): int
    {
        return $this->createQueryBuilder('p')
            ->select('MAX(p.updatedAt) as lastUpdate')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
