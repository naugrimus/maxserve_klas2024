<?php

namespace App\Factories;

use App\Entity\Product;
use App\Repository\ProductRepository;

class ProductFactory implements ProductFactoryInterface
{
    protected ProductRepository $repository;

    public function __construct(ProductRepository $repository) {
        $this->repository = $repository;
    }

    public function create(string $title): Product {
        $entity = $this->repository->findOneBy(['title' => $title]);
        if(!$entity) {
            return new Product();
        }
        return $entity;
    }
}