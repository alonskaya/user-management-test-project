<?php

namespace App\Repository;

use App\Entity\Group;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class GroupRepository
 * @package App\Repository
 */
class GroupRepository extends ServiceEntityRepository implements DefaultRepositoryInterface
{
    /**
     * GroupRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Group::class);
    }

    /**
     * @param array $criteria
     *
     * @return array
     */
    public function findByWithJoins(array $criteria): array
    {
        $joinFields   = ['users'];
        $queryBuilder = $this->createQueryBuilder('g');

        foreach ($criteria as $name => $criterion) {
            if (in_array($name, $joinFields, true)) {
                $queryBuilder->innerJoin('g.' . $name, $name)
                    ->where($queryBuilder->expr()->eq($name . '.id', $criterion));
            } else {
                $queryBuilder->where('g.' . $name . ' = ' .
                                     (is_string($criterion) ? '\'' . $criterion . '\'' : $criterion));
            }
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
