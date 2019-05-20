<?php

namespace App\Repository;

use App\Entity\Group;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class GroupRepository
 * @package App\Repository
 */
class GroupRepository extends ServiceEntityRepository implements AutoJoinRepositoryInterface
{
    use AutoJoinRepositoryTrait;

    /**
     * GroupRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Group::class);
    }
}
