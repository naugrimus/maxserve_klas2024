<?php

namespace App\Factories;

use App\Entity\Interfaces\canCreateWithFactoryInterface;
use App\Entity\ProductCategory;

interface CategoryFactoryInterface
{
    public function create(string $category): canCreateWithFactoryInterface;
}