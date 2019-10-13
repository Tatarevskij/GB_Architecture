<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 14.10.2019
 * Time: 0:03
 */

declare(strict_types = 1);

namespace Service\Order;

use Service\Billing\BillingInterface;
use Service\Communication\CommunicationInterface;
use Service\Discount\DiscountInterface;
use Service\User\SecurityInterface;
use Model\Entity\Product;

class BasketBuilder
{
    /**
     * @var BillingInterface
     */
    private $billing;

    /**
     * @var DiscountInterface
     */
    private $discount;

    /**
     * @var CommunicationInterface
     */
    private $communication;

    /**
     * @var SecurityInterface
     */
    private $security;

    /**
     * @var Product[]
     */
    private $products;

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param Product[] $products
     * @return BasketBuilder
     */
    public function setProducts(array $products): BasketBuilder
    {
        $this->products = $products;
        return $this;
    }

    /**
     * @return BillingInterface
     */
    public function getBilling(): BillingInterface
    {
        return $this->billing;
    }

    /**
     * @param BillingInterface $billing
     * @return BasketBuilder
     */
    public function setBilling(BillingInterface $billing): BasketBuilder
    {
        $this->billing = $billing;
        return $this;
    }

    /**
     * @return DiscountInterface
     */
    public function getDiscount(): DiscountInterface
    {
        return $this->discount;
    }

    /**
     * @param DiscountInterface $discount
     * @return BasketBuilder
     */
    public function setDiscount(DiscountInterface $discount): BasketBuilder
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return CommunicationInterface
     */
    public function getCommunication(): CommunicationInterface
    {
        return $this->communication;
    }

    /**
     * @param CommunicationInterface $communication
     * @return BasketBuilder
     */
    public function setCommunication(CommunicationInterface $communication): BasketBuilder
    {
        $this->communication = $communication;
        return $this;
    }

    /**
     * @return SecurityInterface
     */
    public function getSecurity(): SecurityInterface
    {
        return $this->security;
    }

    /**
     * @param SecurityInterface $security
     * @return BasketBuilder
     */
    public function setSecurity(SecurityInterface $security): BasketBuilder
    {
        $this->security = $security;
        return $this;
    }

    /**
     * @return Checkout
     */
    public function build(): Checkout
    {
        return new Checkout($this);
    }
}

