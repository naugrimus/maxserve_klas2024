<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\ProductTags;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductTags>
 */
class ProductTagsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductTags::class);
    }

    public function deleteTagsFromProduct(Product $product): void {
        $tags = $this->findBy(['product' => $product->getId()]);
        foreach($tags as $tag) {
            $this->getEntityManager()->remove($tag);
        }
        $this->getEntityManager()->flush();
    }
}
