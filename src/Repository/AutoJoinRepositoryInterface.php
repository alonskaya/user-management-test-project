<?php

namespace App\Repository;

/**
 * Interface AutoJoinRepositoryInterface
 * @package App\Repository
 */
interface AutoJoinRepositoryInterface
{
    /**
     * @param array $criteria
     *
     * @return array
     */
    public function findByWithJoins(array $criteria): array;
}
