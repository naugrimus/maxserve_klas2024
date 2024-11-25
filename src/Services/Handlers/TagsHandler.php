<?php

namespace App\Services\Handlers;

use App\Entity\Product;
use App\Entity\ProductTags;
use App\Repository\ProductTagsRepository;

class TagsHandler implements hasImportHandlerInterface
{
    protected ProductTagsRepository $repository;

    public function __construct(ProductTagsRepository $repository) {
        $this->repository = $repository;
    }

    public function import(Product $product, \StdClass $item): void {

        $this->removeTags($product);
        foreach ($item->tags as $tag) {
            $productTag = new ProductTags();
            $productTag->setTag($tag);
            $product->addTag($productTag);
        }
    }

    protected function removeTags(Product $product): void {
        $this->repository->deleteTagsFromProduct($product);
        foreach($product->getTags() as $tag) {
            $product->removeTag($tag);
        }
    }
}