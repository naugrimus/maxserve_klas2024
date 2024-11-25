<?php

namespace App\Services\Handlers;

use App\Entity\Product;
use App\Entity\ProductImage;
use App\Repository\ProductImageRepository;
use App\Services\ImageHandler\ImageHandler;
use stdClass;
class ProductImageHandler implements hasImportHandlerInterface
{

    protected ProductImageRepository $repository;

    protected ImageHandler $imageHandler;

    protected bool $useLocalImages = false;

    public function __construct(ProductImageRepository $repository, ImageHandler $imageHandler) {
        $this->repository = $repository;
        $this->imageHandler = $imageHandler;
    }

    public function setUseLocalImages($useLocalImages): void {
        $this->useLocalImages = $useLocalImages;
    }

    public function Import(Product $product, stdClass $item): void {
        $this->removeProductImages($product);
        foreach($item->images as $image) {
            $productImage = new ProductImage();
            $productImage->setUrl($image);
            if($this->useLocalImages) {
                $file =  $this->imageHandler->download($image);
                $productImage->setLocal($file);
            }
            $product->addProductImage($productImage);
        }
    }

    protected function removeProductImages(Product $product): void {
        $this->repository->deleteImagesFromProduct($product);
    }
}