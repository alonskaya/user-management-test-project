<?php

namespace App\Repository;

/**
 * Trait AutoJoinRepositoryTrait
 * @package App\Repository
 */
trait AutoJoinRepositoryTrait
{
    /**
     * @return array
     */
    protected function getAssociatedEntities(): array
    {
        $associatedFields = [];
        $metadata         = $this->getEntityManager()->getClassMetadata($this->_entityName);

        foreach ($metadata->associationMappings as $fieldMetadata) {
            $associatedFields[] = $fieldMetadata['fieldName'];
        }

        return $associatedFields;
    }

    /**
     * @param array $criteria
     *
     * @return array
     */
    public function findByWithJoins(array $criteria): array
    {
        $associatedFields = $this->getAssociatedEntities();
        $queryBuilder     = $this->createQueryBuilder('main');

        foreach ($criteria as $name => $criterion) {
            if (in_array($name, $associatedFields, true)) {
                $queryBuilder->innerJoin('main.' . $name, $name)
                    ->where($queryBuilder->expr()->eq($name . '.id', $criterion));
            } else {
                $queryBuilder->where('main.' . $name . ' = ' .
                                     (is_string($criterion) ? '\'' . $criterion . '\'' : $criterion));
            }
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
