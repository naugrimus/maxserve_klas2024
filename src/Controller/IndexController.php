<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductBrandRepository;
use App\Repository\ProductCategoryRepository;
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
        #[MapQueryParameter] int $page = null,
        #[MapQueryParameter] int $brand = null,
        #[MapQueryParameter] int $category = null,
        #[MapQueryParameter] string $sort = null,
        #[MapQueryParameter] string $sortDirection = null,
        ProductBrandRepository $brandRepository,
        ProductCategoryRepository $categoryRepository
    ): Response {

        $brands = $brandRepository->fetchAllSorted();
        $categories = $categoryRepository->fetchAllSorted();

        if(!isset($page)) {
            $page = 1;
        }

        $pager = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new QueryAdapter($this->productRepository->searchByBrandOrCategory(
                $brand,
                $category,
                $sort,
                $sortDirection
            )),
            $page,
            10);

       return  $this->render('products/overview.html.twig',
            [
                'products' => $pager,
                'brands' => $brands,
                'categories' => $categories,
                'sort' => $sort,
                'sortDirection' => $sortDirection,
            ]
        );
    }

    #[Route('/details/{id}', name: 'details')]
    public function detailsAction(Product $product): Response {
        return  $this->render('products/product.html.twig',
            [
                'product' => $product,
            ]
        );
    }


}