<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 16.10.2019
 * Time: 19:42
 */
declare(strict_types = 1);

namespace Service\Product;


interface ComparatorInterface
    /**
     * @param $a
     * @param $b
     * @return int
     */
{
    public function compare ($a, $b): int;
}