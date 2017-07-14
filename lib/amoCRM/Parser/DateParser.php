<?php

namespace amoCRM\Parser;

use amoCRM\Exception;

/**
 * Class DateParser
 * @package amoCRM\Parser
 */
final class DateParser
{
    /**
     * @param string|integer $date
     * @return int
     * @throws Exception\InvalidArgumentException
     */
    public static function parseDate($date)
    {
        if (is_numeric($date)) {
            return (int)$date;
        }

        $result = null;

        if (is_string($date)) {
            $result = strtotime($date) ?: null;
        }

        if ($result === null) {
            throw new Exception\InvalidArgumentException(sprintf('Invalid date "%s"', $date));
        }

        return $result;
    }

    /**
     * @param string $format
     * @param string $date
     * @return int
     * @throws Exception\InvalidArgumentException
     */
    public static function fromFormat($format, $date)
    {
        $date_time = \DateTime::createFromFormat($format, $date);

        if ($date_time === false) {
            throw new Exception\InvalidArgumentException(sprintf('Invalid date "%s"', $date));
        }

        return $date_time->getTimestamp();
    }
}
