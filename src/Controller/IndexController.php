<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;

class IndexController extends AbstractController
{

    protected ProductRepository $productRepository;
    public function __construct(ProductRepository $productRepository) {
        $this->productRepository = $productRepository;
    }

    #[Route('/', name: 'home')]
    public function indexAction(
        #[MapQueryParameter] int $page = 1,
        #[MapQueryParameter] string $brand = null,
        #[MapQueryParameter] string $category = null
    ): Response {

        $pager = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new QueryAdapter($this->productRepository->searchByBrandOrCategory(
                $brand,
                $category
            )),
            $page,
            10);

       return  $this->render('products/overview.html.twig',
            [
                'products' => $pager]
        );
    }

    #[Route('/details/{id}', name: 'details')]
    public function detailsAction(Product $product) {
        return  $this->render('products/product.html.twig',
            [
                'product' => $product]
        );
    }


}