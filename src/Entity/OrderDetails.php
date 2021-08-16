<?php

namespace App\Entity;

use App\Repository\OrderDetailsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderDetailsRepository::class)
 */
class OrderDetails
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="orderdetails")
     */
    private $order;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="orderdetails")
     */
    private $product;

    /**
     * @ORM\Column(type="datetime", length=255)
     */
    private $created_at;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $amount;

    public function __construct()
    {
        $this->created_at = new \DateTime("now");
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(Order $order)
    {
        $this->order = $order;

        return $this;
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

    public function getCreateAt() {
        return $this->created_at;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(?int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}
