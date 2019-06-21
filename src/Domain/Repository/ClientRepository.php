<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Client;
use App\Domain\Repository\Interfaces\Manageable;
use App\Domain\Repository\Interfaces\Queryable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class ClientRepository
 * @author ereshkidal
 */
final class ClientRepository extends ServiceEntityRepository implements Manageable, Queryable
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
    public function findAllQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.updatedAt', 'DESC');
    }

    /**
     * {@inheritdoc}
     */
    public function findAllByRetailerQueryBuilder(string $retailerUuid): ?QueryBuilder
    {
        return $this->createQueryBuilder('c')
            ->where('c.retailer = :retailerUuid')
            ->orderBy('c.updatedAt', 'DESC')
            ->setParameter('retailerUuid', $retailerUuid);
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
