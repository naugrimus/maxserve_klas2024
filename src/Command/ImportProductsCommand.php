<?php

namespace App\Command;

use App\Entity\Product;
use App\Entity\ProductBrand;
use App\Entity\ProductCategory;
use App\Entity\ProductImage;
use App\Factories\ProductEntityFactory;
use App\Services\ImageHandler\imageHandlerInterface;
use App\Services\ProductApi\DataFetcherInterface;
use App\Services\ProductImporterInterface;
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
    protected SymfonyStyle $style;

    protected ProductEntityFactory $factory;

    protected bool $useLocalImages;

    protected string $url;
    protected imageHandlerInterface $imageHandler;

    protected ProductImporterInterface $productImporter;

    public function __construct(
        string $useLocalImages,
        string $url,
        ProductImporterInterface $productImporter,
        SymfonyStyle $style
    )
    {
        $this->useLocalImages = filter_var($useLocalImages, FILTER_VALIDATE_BOOLEAN);
        $this->url = $url;
        $this->productImporter = $productImporter;
        $this->style = $style;


        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        try {
            $item = $this->productImporter->import($this->url, $this->useLocalImages);
            foreach ($item as $product) {
                $this->style->note(sprintf("Importing item %s", $product->title));
            }
        } catch (\Exception $e) {
            $this->style->error($e->getMessage());
            exit(0);
        }

        return Command::SUCCESS;
    }


}
