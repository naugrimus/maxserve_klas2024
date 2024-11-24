<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\ProductReview;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductReview>
 */
class ProductReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductReview::class);
    }

    public function deleteReviewsFromProduct(Product $product): void {
        $images = $this->findBy(['product' => $product->getId()]);
        foreach($images as $image) {
            $this->getEntityManager()->remove($image);
        }
        $this->getEntityManager()->flush();
    }
}
