<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Client;
use App\Domain\Repository\Interfaces\Manageable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class ClientRepository
 * @author ereshkidal
 */
final class ClientRepository extends ServiceEntityRepository implements Manageable
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
    public function save($entity): void
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function update($entity): void
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function remove(string $id): bool
    {
        $entity = $this->find($id);
        if (null === $entity) {
            return false;
        }
        $this->_em->remove($entity);
        $this->_em->flush();

        return true;
    }
}
