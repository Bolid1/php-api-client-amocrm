<?php

namespace amoCRM\Parser;

use amoCRM\Exception;

/**
 * Class NumberValidator
 * @package amoCRM\Validator
 */
final class NumberParser
{
    /**
     * @param array .<int> $arr
     * @param bool $can_be_equal_zero
     * @param bool $can_be_less_zero
     * @return array
     * @throws \amoCRM\Exception\ValidateException
     */
    public static function parseIntegersArray(array $arr, $can_be_equal_zero = false, $can_be_less_zero = false)
    {
        foreach ($arr as &$item) {
            $item = self::parseInteger($item, $can_be_equal_zero, $can_be_less_zero);
        }

        return $arr;
    }

    /**
     * @param integer $number
     * @param bool $can_be_equal_zero
     * @param bool $can_be_less_zero
     * @return int
     * @throws \amoCRM\Exception\ValidateException
     */
    public static function parseInteger($number, $can_be_equal_zero = false, $can_be_less_zero = false)
    {
        self::ensureIsNumeric($number);

        $integer = (int)$number;
        if ($can_be_less_zero !== true) {
            self::ensureGreaterOrEqualZero($number, $integer);
        }

        if ($can_be_equal_zero !== true) {
            self::ensureNotEqualZero($number, $integer);
        }

        return $integer;
    }

    /**
     * @param $int
     * @throws Exception\ValidateException
     */
    private static function ensureIsNumeric($int)
    {
        if (!is_numeric($int)) {
            throw new Exception\ValidateException(sprintf('"%s" is not a number', $int));
        }
    }

    /**
     * @param integer $number
     * @param integer $integer
     * @throws Exception\ValidateException
     */
    private static function ensureGreaterOrEqualZero($number, $integer)
    {
        if ($integer < 0) {
            throw new Exception\ValidateException(sprintf('"%s" is less zero', $number));
        }
    }

    /**
     * @param integer $number
     * @param integer $integer
     * @throws Exception\ValidateException
     */
    private static function ensureNotEqualZero($number, $integer)
    {
        if ($integer === 0) {
            throw new Exception\ValidateException(sprintf('"%s" is equal zero', $number));
        }
    }
}
