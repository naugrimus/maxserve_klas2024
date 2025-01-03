<?php

namespace App\Command;

use App\Factories\ProductEntityFactory;
use App\Services\ProductImporterInterface;
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

    protected bool $checkUpdateDate;

    protected string $url;


    protected ProductImporterInterface $productImporter;

    public function __construct(
        string $useLocalImages,
        string $url,
        string $checkUpdateDate,
        ProductImporterInterface $productImporter,
        SymfonyStyle $style
    )
    {
        $this->useLocalImages = filter_var($useLocalImages, FILTER_VALIDATE_BOOLEAN);
        $this->checkUpdateDate = filter_var($checkUpdateDate, FILTER_VALIDATE_BOOLEAN);
        $this->url = $url;
        $this->productImporter = $productImporter;

        $this->style = $style;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        try {
            $item = $this->productImporter->import($this->url, $this->useLocalImages, $this->checkUpdateDate);
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
