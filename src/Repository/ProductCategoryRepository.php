<?php

namespace App\Repository;

use App\Entity\ProductCategory;
use App\Repository\traits\SortingTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductCategory>
 */
class ProductCategoryRepository extends ServiceEntityRepository implements FetchAllSortedInterface
{
    use SortingTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductCategory::class);
    }

    public function fetchAllSorted($sort = 'ASC') {
        return $this->fetchSorted('category', $sort);
    }
}
