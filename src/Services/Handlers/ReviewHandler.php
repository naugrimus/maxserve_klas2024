<?php

namespace App\Services\Handlers;

use App\Entity\Product;
use App\Entity\ProductReview;
use App\Repository\ProductReviewRepository;

class ReviewHandler implements hasImportHandlerInterface
{
    protected ProductReviewRepository $repository;
    public function __construct(ProductReviewRepository $repository) {
        $this->repository = $repository;
    }

    public function import(Product $product, \StdClass $item): void {

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
        $this->repository->deleteReviewsFromProduct($product);
        foreach($product->getReviews() as $review) {
            $product->removeReview($review);
        }
    }
}