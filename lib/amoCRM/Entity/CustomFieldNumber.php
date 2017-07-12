<?php

namespace amoCRM\Entity;

use amoCRM\Validator\NumberValidator;

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
        $this->value = NumberValidator::parseInteger($value, true);
    }
}
