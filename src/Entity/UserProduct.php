<?php

namespace App\Entity;

use App\Repository\UserProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserProductRepository::class)
 */
class UserProduct
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="user_products")
     */
    private $product;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="user_products")
     */
    private $user;

    /**
     * @ORM\Column(type="datetime", length=255)
     */
    private $created_at;

    public function __construct()
    {
        $this->created_at = new \DateTime("now");
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUserId(User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function getCreateAt() {
        return $this->created_at;
    }
}
