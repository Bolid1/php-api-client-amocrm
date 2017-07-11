<?php

namespace amoCRM\Entities\Elements\CustomFields;

use amoCRM\Exceptions;

/**
 * Class CustomFieldDate
 * @package amoCRM\Entities\Elements\CustomFields
 * Represents date custom field of amoCRM
 */
final class CustomFieldDate extends CustomFieldSingleValue
{
    private $date_format = 'd.m.Y';

    /**
     * @return string current used date format
     */
    public function getDateFormat()
    {
        return $this->date_format;
    }

    /**
     * @param string $value - date in format $this->_date_format
     * @throws \amoCRM\Exceptions\InvalidArgumentException
     */
    public function setValue($value)
    {
        $this->setTimestamp($this->parseDate($value));
    }

    /**
     * @param string $timestamp - date timestamp
     * @throws \amoCRM\Exceptions\InvalidArgumentException
     */
    public function setTimestamp($timestamp)
    {
        $this->value = $this->parseNumber($timestamp, true, true);
    }

    /**
     * @param string $date
     * @return int
     * @throws Exceptions\InvalidArgumentException
     */
    private function parseDate($date)
    {
        $date_time = \DateTime::createFromFormat($this->date_format, $date);

        if ($date_time === false) {
            throw new Exceptions\InvalidArgumentException(sprintf('Invalid date "%s"', $date));
        }

        return $date_time->getTimestamp();
    }

    /**
     * @return string
     */
    protected function prepareToAmo()
    {
        return $this->value === null ? '' : date($this->date_format, $this->value);
    }
}
