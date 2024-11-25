<?php

namespace App\Services\Handlers;

use App\Entity\Product;
use stdClass;

interface hasImportHandlerInterface
{
    public function Import(Product $product, stdClass $item): void;

}