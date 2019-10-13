<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 14.10.2019
 * Time: 0:04
 */



declare(strict_types = 1);

namespace Service\Order;

use Model\Entity\Product;
use Service\Billing\Exception\BillingException;
use Service\Billing\BillingInterface;
use Service\Communication\Exception\CommunicationException;
use Service\Communication\CommunicationInterface;
use Service\Discount\DiscountInterface;
use Service\User\SecurityInterface;

class Checkout
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
     * Checkout constructor.
     * @param BasketBuilder $builder
     */
    public function __construct(BasketBuilder $builder)
    {
        $this->products = $builder->getProducts();
        $this->discount = $builder->getDiscount();
        $this->billing = $builder->getBilling();
        $this->security = $builder->getSecurity();
        $this->communication = $builder->getCommunication();
    }

    /**
     * @throws BillingException
     * @throws CommunicationException
     */
    public function checkoutProcess(): void
    {
        $totalPrice = 0;
        foreach ($this->products as $product) {
            $totalPrice += $product->getPrice();
        }

        $discount = $this->discount->getDiscount();
        $totalPrice = $totalPrice - $totalPrice / 100 * $discount;

        $this->billing->pay($totalPrice);

        $user = $this->security->getUser();
        $this->communication->process($user, 'checkout_template');
    }
}

