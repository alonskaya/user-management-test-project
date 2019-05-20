<?php

namespace App\Repository;

/**
 * Interface DefaultRepositoryInterface
 * @package App\Repository
 */
interface DefaultRepositoryInterface
{
    /**
     * @param array $criteria
     *
     * @return array
     */
    public function findByWithJoins(array $criteria): array;
}
