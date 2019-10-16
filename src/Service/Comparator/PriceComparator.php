<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 16.10.2019
 * Time: 20:11
 */

declare(strict_types = 1);

namespace Service\Comparator;


use Model\Entity\Product;
use Service\Product\ComparatorInterface;

class PriceComparator implements ComparatorInterface
{
    /**
     * @param Product $a
     * @param Product $b
     * @return int
     */

    public function compare ($a, $b): int
    {
        return $a->getPrice() <=> $b->getPrice();
    }


}