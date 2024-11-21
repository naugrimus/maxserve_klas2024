<?php

namespace App\Factories;

use App\Entity\Product;
use App\Entity\ProductBrand;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class ProductEntityFactory
{

    protected EntityManagerInterface $entityManager;
    protected ProductFactoryInterface $productFactory;

    protected BrandFactoryInterface $brandFactory;
    public function __construct(
        ProductFactoryInterface $productFactory,
        BrandFactoryInterface $brandFactory,
        EntityManagerInterface $entityManager) {

        $this->brandFactory = $brandFactory;
        $this->productFactory = $productFactory;
        $this->entityManager = $entityManager;
    }

    public function createProduct(string $title) {
        return $this->productFactory->create($title);
    }

    public function createProductBrand(string $brand) {
        return $this->brandFactory->create($brand);
    }
    public function upsert(Product $product) {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }
}