<?php

namespace App\Services;

use App\Entity\Product;
use App\Entity\ProductBrand;
use App\Entity\ProductCategory;
use App\Entity\ProductImage;
use App\Entity\ProductReview;
use App\Factories\ProductEntityFactory;
use App\Repository\ProductImageRepository;
use App\Services\ImageHandler\imageHandlerInterface;
use App\Services\ProductApi\DataFetcherInterface;
use Doctrine\DBAL\Driver\Exception;
use Generator;
use stdClass;
class ProductImporter implements ProductImporterInterface
{

    protected DataFetcherInterface $productApi;

    protected ProductEntityFactory $factory;

    protected imageHandlerInterface $imageHandler;

    protected ProductImageRepository $imageRepository;
    protected bool $useLocalImages;
    public function __construct(
                                DataFetcherInterface $productApi,
                                ProductEntityFactory $factory,
                                imageHandlerInterface $imageHandler,
                                ProductImageRepository $imageRepository,

    ) {
        $this->productApi = $productApi;
        $this->factory = $factory;
        $this->imageHandler = $imageHandler;
        $this->imageRepository = $imageRepository;

    }

    /**
     * @throws \Exception
     */
    public function import(string $url, $useLocalImages = true): Generator {

        $json = $this->productApi->fetchData($url);
        $this->useLocalImages = $useLocalImages;
        foreach($json->products as $item) {
            yield $item;

            $this->upsertProduct($item);
        }
    }

    protected function upsertProduct(stdClass $item): void {
        $product = $this->getProductEntity($item->title);

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
            ->setDiscountPercentage($item->discountPercentage);

        if(isset($item->brand)) {
            $product->setBrand($this->getBrandEntity($item->brand));
        }

        $this->setProductImages($product, $item);
        $this->handleReviews($product, $item);
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

    protected function setProductImages(Product $product, stdClass $item): void {
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
        $this->imageRepository->deleteImagesFromProduct($product);
    }

    protected function handleReviews(Product $product, \StdClass $item): void {

        $this->removeReviews($product);
        foreach ($item->reviews as $review) {
            $date = new \DateTimeImmutable($review->date);
            $productReview = new ProductReview();
            $productReview->setReviewDate($date);
            $productReview->setComment($review->comment);
            $productReview->setName($review->reviewerName);
            $productReview->setEmail($review->reviewerEmail);
            $productReview->setRating($review->rating);
            $product->addReview($productReview);
        }
    }

    protected function removeReviews(Product $product): void {
        foreach($product->getReviews() as $review) {
            $product->removeReview($review);
        }
    }
}