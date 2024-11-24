<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\ProductImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductImage>
 */
class ProductImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductImage::class);
    }

    public function deleteImagesFromProduct(Product $product): void {
        $images = $this->findBy(['product' => $product->getId()]);
        foreach($images as $image) {
            $this->getEntityManager()->remove($image);
        }
        $this->getEntityManager()->flush();
    }
}
