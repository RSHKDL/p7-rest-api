<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Tablet;
use App\Domain\Repository\Interfaces\EntityRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class TabletRepository
 * @author ereshkidal
 */
class TabletRepository extends ServiceEntityRepository implements EntityRepositoryInterface
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
     * @return QueryBuilder
     */
    public function findAllQueryBuilder(): QueryBuilder
    {
        // TODO: Implement findAllQueryBuilder() method.
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
