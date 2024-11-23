<?php

namespace App\Factories;

use App\Entity\ProductBrand;
use App\Repository\ProductBrandRepository;
use App\Repository\ProductRepository;
use Doctrine\Entity;
use Doctrine\ORM\EntityManagerInterface;

class BrandFactory implements BrandFactoryInterface
{
    protected EntityManagerInterface $entityManager;

    protected ProductBrandRepository $repository;
    public function __construct(ProductBrandRepository $repository, EntityManagerInterface $entityManager) {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    public function create(string $brand): ProductBrand {
        $entity = $this->repository->findOneBy(['brand' => $brand]);
        if(!$entity) {
            $entity = new ProductBrand();
            $entity->setBrand($brand);
            return $entity;
        }

        return $entity;
    }
}