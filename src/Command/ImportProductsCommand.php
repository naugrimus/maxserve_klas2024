<?php

namespace App\Command;

use App\Entity\Product;
use App\Entity\ProductBrand;
use App\Entity\ProductCategory;
use App\Factories\ProductEntityFactory;
use App\Entity\ProductImage;
use App\Services\ImageHandler;
use App\Services\ProductApi\DataFetcherInterface;
use Doctrine\DBAL\Driver\Exception;
use stdClass;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


#[AsCommand(
    name: 'app:import-products',
    description: 'Imports the products',
)]
class ImportProductsCommand extends Command
{
    protected DataFetcherInterface $productApi;

    protected SymfonyStyle $style;

    protected ProductEntityFactory $factory;

    protected bool $useLocalImages;

    protected ImageHandler $imageHandler;

    public function __construct(string $useLocalImages,
                                SymfonyStyle $style,
                                DataFetcherInterface $productApi,
                                ProductEntityFactory $factory,
                                ImageHandler $imageHandler
    )
    {
        $this->style = $style;
        $this->productApi = $productApi;
        $this->factory = $factory;
        $this->imageHandler = $imageHandler;
        $this->useLocalImages = filter_var($useLocalImages, FILTER_VALIDATE_BOOLEAN);

        parent::__construct();
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $json = $this->productApi->fetchData();

        foreach($json->products as $item) {
            $this->style->note(sprintf("Importing item %s", $item->title));
            $this->upsertProduct($item);
        }

        return Command::SUCCESS;
    }

    protected function upsertProduct(stdClass $item) {
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

        if($this->useLocalImages) {
            // download the images to local
           $file =  $this->imageHandler->download($item->thumbnail);
           $product->setThumbnailLocal($file);
        }
        try {
            $this->factory->upsert($product);
        } catch (Exception $e) {
            $this->style->error(sprintf($e->getMessage() . ' for %s', $item->title));
            exit (0);
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
                $file =  $this->imageHandler->download($item->thumbnail);
                $productImage->setLocal($file);
            }
            $product->addProductImage($productImage);
        }
    }

    protected function removeProductImages(Product $product): void {

        // remove images from the product
        foreach($product->getProductImages() as $productImage) {
            $product->removeProductImage($productImage);
        }
    }
}
