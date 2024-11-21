<?php

namespace App\Factories;

use App\Entity\Product;

interface ProductFactoryInterface
{

    public function create(string $title): Product;
}