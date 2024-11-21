<?php

namespace App\Factories;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProductFactory implements ProductFactoryInterface
{
    protected ProductRepository $repository;
    protected EntityManagerInterface $entityManager;
    public function __construct(ProductRepository $repository, EntityManagerInterface $entityManager) {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    public function create(string $title): Product {
        $entity = $this->repository->findOneBy(['title' => $title]);
        if(!$entity) {
            return new Product();
        }
        return $entity;
    }


}