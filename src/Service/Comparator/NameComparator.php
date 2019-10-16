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

class NameComparator implements ComparatorInterface
{
    /**
     * @param Product $a
     * @param Product $b
     * @return int
     */

    public function compare ($a, $b): int
    {
        return $a->getName()[0] <=> $b->getName()[0];
    }


}