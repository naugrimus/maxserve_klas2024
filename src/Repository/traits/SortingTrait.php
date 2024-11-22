<?php

namespace App\Repository\traits;

trait SortingTrait
{
    public function fetchSorted(string $fieldName, string $sort) {
        return $this->createQueryBuilder('c')
            ->orderBy('c.' . $fieldName, $sort)
            ->getQuery()
            ->getResult();


    }
}