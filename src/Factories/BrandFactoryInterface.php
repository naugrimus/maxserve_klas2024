<?php

namespace App\Factories;

use App\Entity\ProductBrand;

interface BrandFactoryInterface
{
    public function create(string $brand): ProductBrand;
}