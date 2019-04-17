<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Phone;
use App\Domain\Repository\Interfaces\EntityRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class PhoneRepository
 * @author ereshkidal
 */
class PhoneRepository extends ServiceEntityRepository implements EntityRepositoryInterface
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
        return $this->createQueryBuilder('phone');
    }

    /**
     * @param Phone $phone
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Phone $phone): void
    {
        $this->_em->persist($phone);
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
        $phone = $this->find($id);
        if (null === $phone) {
            return false;
        }
        $this->_em->remove($phone);
        $this->_em->flush();

        return true;
    }
}
