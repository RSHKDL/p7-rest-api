<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Client;
use App\Domain\Repository\Interfaces\Filterable;
use App\Domain\Repository\Interfaces\Manageable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class ClientRepository
 * @author ereshkidal
 */
final class ClientRepository extends ServiceEntityRepository implements Manageable, Filterable
{
    /**
     * RetailerRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    /**
     * {@inheritdoc}
     */
    public function findAllQueryBuilder(
        ?string $filter = null,
        string $parentResourceUuid = null
    ): ?QueryBuilder {

        $qb = $this->createQueryBuilder('c');
        $qb->andWhere($qb->expr()->eq('c.retailer', ':retailerUuid'));
        $qb->setParameter('retailerUuid', $parentResourceUuid);
        $qb->orderBy('c.updatedAt', 'DESC');

        if ($filter) {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('c.firstName', ':filter'),
                    $qb->expr()->like('c.lastName', ':filter'),
                    $qb->expr()->like('c.email', ':filter')
                )
            )->setParameter('filter', '%'.$filter.'%');
        }

        return $qb;
    }

    /**
     * {@inheritdoc}
     * @param Client $entity
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
     * @param Client $entity
     */
    public function remove($entity): void
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }
}
