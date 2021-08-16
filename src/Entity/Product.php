<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $product_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $product_description;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $product_summary;

     /**
     * @ORM\Column(type="float", length=20)
     */
    private $product_price;

      /**
     * @ORM\Column(type="integer", length=10)
     */
    private $product_amount;

    /**
     * @ORM\Column(type="boolean")
     */
    private $product_status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cart", mappedBy="product")
     */
    private $carts;

    public function __construct()
    {
        $this->user_products = new ArrayCollection();
        $this->cart = new ArrayCollection();
    }

    /**
     * @return Collection|Cart[]
     */
    public function getCarts(): Collection
    {
        return $this->carts;
    }

    /**
     * @return Collection|Product[]
     */
    public function getUserProducts(): Collection
    {
        return $this->user_products;
    }


      /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserProduct", mappedBy="product")
     */
    private $user_products;

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductName(): ?string
    {
        return $this->product_name;
    }

    public function setProductName(string $product_name): self
    {
        $this->product_name = $product_name;
        return $this;
    }

    public function getProductDescription(): ?string
    {
        return $this->product_description;
    }

    public function setProductDescription(string $product_description): self
    {
        $this->product_description = $product_description;
        return $this;
    }

    public function getProductSummary(): ?string
    {
        return $this->product_summary;
    }

    public function setProductSummary(string $product_summary): self
    {
        $this->product_summary = $product_summary;
        return $this;
    }

    public function getProductPrice(): ?float
    {
        return $this->product_price;
    }

    public function setProductPrice(float $product_price): self
    {
        $this->product_price = $product_price;
        return $this;
    }

    public function getProductAmount(): ?int
    {
        return $this->product_amount;
    }

    public function setProductAmount(int $product_amount): self
    {
        $this->product_amount = $product_amount;
        return $this;
    }

    public function getProductStatus(): ?bool
    {
        return $this->product_status;
    }

    public function setProductStatus(bool $product_status): self
    {
        $this->product_status = $product_status;

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar)
    {
        if ($avatar != null) {
            $this->avatar = $avatar;
        }
        return $this;
    }
}
