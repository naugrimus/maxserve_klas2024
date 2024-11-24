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

    public function searchByBrandOrCategory(?int $brand, ?int $category, ?string $sort = null, ?string $direction = 'DESC') {
        $qb = $this->createQueryBuilder('p');
        $qb->join('\App\Entity\ProductBrand', 'b');
        $qb->andWhere('b.id = p.brand');
        $qb->join('\App\Entity\ProductCategory', 'c');
        $qb->andWhere('c.id = p.category');

        if($brand) {
            $qb->andWhere('b.id = :brand')
                ->setParameter('brand', $brand);
        }

        if($category) {
            $qb->andWhere('c.id = :category')
                ->setParameter('category', $category);
        }

        if ($sort) {
            switch($sort) {
                case 'brand':
                    $qb->orderBy('b.' . $sort, $direction);
                    break;
                case 'category':
                    $qb->orderBy('c.' . $sort, $direction);
                    break;
                default:
                    $qb->orderBy('p.' . $sort, $direction);
            }
        }

        return $qb;
    }
}
