<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class UserRepository
 * @package App\Repository
 */
class UserRepository extends ServiceEntityRepository implements DefaultRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param array $criteria
     *
     * @return array
     */
    public function findByWithJoins(array $criteria): array
    {
        $joinFields   = ['groups'];
        $queryBuilder = $this->createQueryBuilder('u');

        foreach ($criteria as $name => $criterion) {
            if (in_array($name, $joinFields, true)) {
                $queryBuilder->innerJoin('u.' . $name, $name)
                    ->where($queryBuilder->expr()->eq($name . '.id', $criterion));
            } else {
                $queryBuilder->where($criterion);
            }
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
