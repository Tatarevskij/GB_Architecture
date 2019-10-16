<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 16.10.2019
 * Time: 20:34
 */

declare(strict_types = 1);

namespace Service\Product;


use Model\Entity\Product;

class ProductSorter
{
    /**
     * @var ComparatorInterface
     */

    private $comparator;

    /**
     * ProductSorter constructor
     * @param ComparatorInterface $comparator
     */

    public function __construct(ComparatorInterface $comparator)
    {
        $this->comparator = $comparator;
    }

    /**
     * @param Product[] $products
     * @return Product[]
     */
    public function sort(array $products): array
    {
        usort($products, [$this->comparator, 'compare']);
        return $products;
    }
}