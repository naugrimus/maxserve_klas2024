<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductCategory $category = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2, nullable: true)]
    private ?string $discountPercentage = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2, nullable: true)]
    private ?string $rating = null;

    #[ORM\Column]
    private ?int $stock = null;

    /**
     * @var Collection<int, ProductTags>
     */
    #[ORM\ManyToMany(targetEntity: ProductTags::class, inversedBy: 'products')]
    private Collection $tag;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductBrand $brand = null;

    #[ORM\Column(length: 32)]
    private ?string $sku = null;

    #[ORM\Column]
    private ?int $weight = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $width = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $height = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $depth = null;

    #[ORM\Column(length: 255)]
    private ?string $warrantyInformation = null;

    #[ORM\Column(length: 255)]
    private ?string $shippingInformation = null;

    #[ORM\Column(length: 255)]
    private ?string $availabilityStatus = null;

    #[ORM\Column(length: 255)]
    private ?string $returnPolicy = null;

    #[ORM\Column]
    private ?int $minimumOrderQuantity = null;

    #[ORM\Column(length: 255)]
    private ?string $barcode = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $qrCode = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $thumbnail = null;

    public function __construct()
    {
        $this->tag = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?Productcategory
    {
        return $this->category;
    }

    public function setCategory(?Productcategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDiscountPercentage(): ?string
    {
        return $this->discountPercentage;
    }

    public function setDiscountPercentage(?string $discountPercentage): static
    {
        $this->discountPercentage = $discountPercentage;

        return $this;
    }

    public function getRating(): ?string
    {
        return $this->rating;
    }

    public function setRating(?string $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return Collection<int, ProductTags>
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(ProductTags $tag): static
    {
        if (!$this->tag->contains($tag)) {
            $this->tag->add($tag);
        }

        return $this;
    }

    public function removeTag(ProductTags $tag): static
    {
        $this->tag->removeElement($tag);

        return $this;
    }

    public function getBrand(): ?ProductBrand
    {
        return $this->brand;
    }

    public function setBrand(?ProductBrand $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): static
    {
        $this->sku = $sku;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getWidth(): ?string
    {
        return $this->width;
    }

    public function setWidth(string $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?string
    {
        return $this->height;
    }

    public function setHeight(string $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getDepth(): ?string
    {
        return $this->depth;
    }

    public function setDepth(string $depth): static
    {
        $this->depth = $depth;

        return $this;
    }

    public function getWarrantyInformation(): ?string
    {
        return $this->warrantyInformation;
    }

    public function setWarrantyInformation(string $warrantyInformation): static
    {
        $this->warrantyInformation = $warrantyInformation;

        return $this;
    }

    public function getShippingInformation(): ?string
    {
        return $this->shippingInformation;
    }

    public function setShippingInformation(string $shippingInformation): static
    {
        $this->shippingInformation = $shippingInformation;

        return $this;
    }

    public function getAvailabilityStatus(): ?string
    {
        return $this->availabilityStatus;
    }

    public function setAvailabilityStatus(string $availabilityStatus): static
    {
        $this->availabilityStatus = $availabilityStatus;

        return $this;
    }

    public function getReturnPolicy(): ?string
    {
        return $this->returnPolicy;
    }

    public function setReturnPolicy(string $returnPolicy): static
    {
        $this->returnPolicy = $returnPolicy;

        return $this;
    }

    public function getMinimumOrderQuantity(): ?int
    {
        return $this->minimumOrderQuantity;
    }

    public function setMinimumOrderQuantity(int $minimumOrderQuantity): static
    {
        $this->minimumOrderQuantity = $minimumOrderQuantity;

        return $this;
    }

    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    public function setBarcode(string $barcode): static
    {
        $this->barcode = $barcode;

        return $this;
    }

    public function getQrCode(): ?string
    {
        return $this->qrCode;
    }

    public function setQrCode(string $qrCode): static
    {
        $this->qrCode = $qrCode;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(string $thumbnail): static
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }
}
