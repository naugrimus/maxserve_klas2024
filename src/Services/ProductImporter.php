<?php

namespace App\Services;

use App\Entity\Product;
use App\Entity\ProductBrand;
use App\Entity\ProductCategory;
use App\Factories\ProductEntityFactory;
use App\Services\Handlers\hasImportHandlerInterface;
use App\Services\Handlers\TagsHandler;
use App\Services\ImageHandler\imageHandlerInterface;
use App\Services\ProductApi\DataFetcherInterface;
use Doctrine\DBAL\Driver\Exception;
use Generator;
use stdClass;
class ProductImporter implements ProductImporterInterface
{

    protected DataFetcherInterface $productApi;

    protected ProductEntityFactory $factory;


    protected hasImportHandlerInterface $productImageHandler;

    protected imageHandlerInterface $imageHandler;

    protected hasImportHandlerInterface $reviewHandler;

    protected bool $useLocalImages;

    protected bool $checkUpdateDate;

    protected TagsHandler $tagsHandler;

    public function __construct(
                                DataFetcherInterface $productApi,
                                ProductEntityFactory $factory,
                                hasImportHandlerInterface $imageHandler,
                                hasImportHandlerInterface $reviewHandler,
                                hasImportHandlerInterface $tagsHandler,
                                imageHandlerInterface $thumbnailHandler

    ) {
        $this->productApi = $productApi;
        $this->factory = $factory;
        $this->productImageHandler = $imageHandler;
        $this->reviewHandler = $reviewHandler;
        $this->tagsHandler = $tagsHandler;
        $this->imageHandler = $thumbnailHandler;
    }

    /**
     * @throws \Exception
     */
    public function import(string $url, $useLocalImages = true, $checkUpdateDate = false): Generator {

        $json = $this->productApi->fetchData($url);
        $this->useLocalImages = $useLocalImages;
        $this->checkUpdateDate = $checkUpdateDate;
        foreach($json->products as $item) {
            yield $item;

            $this->importProduct($item);
        }
    }

    protected function importProduct(stdClass $item): void
    {
        $product = $this->getProductEntity($item->title);
        if ($this->canUpdate($product, $item) || !$product->getApiCreatedAt()) {
            $this->upsertProduct($product, $item);
        }
    }

    protected function upsertProduct(Product $product, stdClass $item): void {
        $product->setTitle($item->title)
            ->setDescription($item->description)
            ->setCategory($this->getCategoryEntity($item->category))
            ->setPrice($item->price)
            ->setStock($item->stock)
            ->setSku($item->sku)
            ->setRating($item->rating)
            ->setAvailabilityStatus($item->availabilityStatus)
            ->setBarCode($item->meta->barcode)
            ->setDepth($item->dimensions->depth)
            ->setHeight($item->dimensions->height)
            ->setWidth($item->dimensions->width)
            ->setWeight($item->weight)
            ->setWarrantyInformation($item->warrantyInformation)
            ->setShippingInformation($item->shippingInformation)
            ->setReturnPolicy($item->returnPolicy)
            ->setMinimumOrderQuantity($item->minimumOrderQuantity)
            ->setQrCode($item->meta->qrCode)
            ->setThumbnail($item->thumbnail)
            ->setDiscountPercentage($item->discountPercentage)
            ->setApiCreatedAt(new \DateTimeImmutable($item->meta->createdAt))
            ->setApiUpdatedAt(new \DateTimeImmutable($item->meta->updatedAt));
        if(isset($item->brand)) {
            $product->setBrand($this->getBrandEntity($item->brand));
        }

        $this->productImageHandler->setUseLocalImages($this->useLocalImages);
        $this->productImageHandler->Import($product, $item);
        $this->reviewHandler->Import($product, $item);
        $this->tagsHandler->import($product, $item);

        if($this->useLocalImages) {
            // download the images to local
            $file =  $this->imageHandler->download($item->thumbnail);
            $product->setThumbnailLocal($file);
        }

        try {
            $this->factory->upsert($product);
        } catch (Exception $e) {
            throw new \Exception(sprintf($e->getMessage() . ' for %s', $item->title));

        }
    }

    protected function getProductEntity(string $title): Product {
        return $this->factory->createProduct($title);
    }

    protected function getBrandEntity(string $brand): ProductBrand {
        return $this->factory->createProductBrand($brand);
    }

    protected function getCategoryEntity(string $category): ProductCategory {
        return $this->factory->createProductCategory($category);
    }

    protected function canUpdate(Product $product, stdClass $item):bool {

        if(!$this->checkUpdateDate) {
            return true;
        } else {
            if ($this->updateBasedOnDate($product, $item)) {
                return true;
            }
        }
        return false;
    }

    protected function updateBasedOnDate(Product $product, stdClass $item): bool {

        $itemDate = new \DateTimeImmutable($item->meta->updatedAt);
        if($product->getApiUpdatedAt()->format('YYY-mm-dd H:i') == $itemDate->format('YYY-mm-dd H:i')) {
            return false;
        }

        return true;
    }

}