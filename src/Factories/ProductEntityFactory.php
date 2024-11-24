<?php

namespace App\Factories;

use App\Entity\Product;
use App\Entity\ProductBrand;
use App\Entity\ProductCategory;
use Doctrine\ORM\EntityManagerInterface;

class ProductEntityFactory
{

    protected EntityManagerInterface $entityManager;
    protected ProductFactoryInterface $productFactory;

    protected BrandFactoryInterface $brandFactory;

    protected CategoryFactoryInterface $categoryFactory;

    public function __construct(
        ProductFactoryInterface $productFactory,
        BrandFactoryInterface $brandFactory,
        CategoryFactoryInterface $categoryFactory,
        EntityManagerInterface $entityManager) {

        $this->productFactory = $productFactory;
        $this->brandFactory = $brandFactory;
        $this->categoryFactory = $categoryFactory;
        $this->entityManager = $entityManager;
    }

    public function createProduct(string $title): Product {
        return $this->productFactory->create($title);
    }

    public function createProductBrand(string $brand): ProductBrand {
        return $this->brandFactory->create($brand);
    }

    public function createProductCategory(string $category): ProductCategory {
        return $this->categoryFactory->create($category);
    }
    public function upsert(Product $product): void {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }
}