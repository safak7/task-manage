<?php

namespace App\Helper;

class NumberHelper extends AbstractHelper
{
    /**
     * @param $number
     * @param int $decimalNumber
     * @param string $decimalSeparator
     * @param string $thousandsSeparator
     * @return string
     */
    public static function numberFormat($number, $decimalNumber = 0, $decimalSeparator = '.', $thousandsSeparator = ',')
    {
        return number_format(floatval($number), $decimalNumber, $decimalSeparator, $thousandsSeparator);
    }
}