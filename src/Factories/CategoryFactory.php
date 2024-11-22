<?php

namespace App\Factories;

use App\Entity\ProductCategory;
use App\Repository\ProductCategoryRepository;

class CategoryFactory implements CategoryFactoryInterface
{
    protected ProductCategoryRepository $repository;

    public function __construct(ProductCategoryRepository $repository) {
        $this->repository = $repository;
    }
    public function create(string $category): ProductCategory {
        $entity = $this->repository->findOneBy(['category' => $category]);
        if(!$entity) {

            $entity = new ProductCategory();
            $entity->setCategory($category);
            return $entity;

        }
        return $entity;
    }
}