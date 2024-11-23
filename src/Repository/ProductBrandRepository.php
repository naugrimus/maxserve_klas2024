<?php

namespace App\Repository;

use App\Entity\ProductBrand;
use App\Repository\traits\SortingTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductBrand>
 */
class ProductBrandRepository extends ServiceEntityRepository implements FetchAllSortedInterface
{
    use SortingTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductBrand::class);
    }

    public function fetchAllSorted($sort = 'ASC') {
        return $this->fetchSorted('brand', $sort);
    }
}
