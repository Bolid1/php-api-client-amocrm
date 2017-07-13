<?php

namespace amoCRM\Entity;

use amoCRM\Parser\NumberParser;

/**
 * Class CustomFieldNumber
 * @package amoCRM\Entity
 * Represents numeric custom field of amoCRM
 * @warning Value must be non-negative integer
 */
final class CustomFieldNumber extends CustomFieldSingleValue
{
    /**
     * @param integer $value
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setValue($value)
    {
        $this->value = NumberParser::parseInteger($value, true);
    }
}
