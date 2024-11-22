<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function searchByBrandOrCategory(?int $brand, ?int $category, ?string $sort = null, string $direction = 'DESC') {
        $qb = $this->createQueryBuilder('p');

        if($brand) {
            $qb->andWhere('p.brand = :brand')
                ->setParameter('brand', '%' . $brand . '%');
        }

        if($brand) {
            $qb->andWhere('p.category = :category')
                ->setParameter('category', '%' . $category . '%');
        }

        if ($sort) {
            $qb->orderBy('p.' . $sort, $direction);
        }

        return $qb;
    }

}
