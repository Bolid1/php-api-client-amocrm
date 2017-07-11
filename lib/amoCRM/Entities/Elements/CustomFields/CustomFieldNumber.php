<?php

namespace amoCRM\Entities\Elements\CustomFields;

/**
 * Class CustomFieldNumber
 * @package amoCRM\Entities\Elements\CustomFields
 * Represents numeric custom field of amoCRM
 * @warning Value must be non-negative integer
 */
final class CustomFieldNumber extends CustomFieldSingleValue
{
    /**
     * @param integer $value
     * @throws \amoCRM\Exceptions\InvalidArgumentException
     */
    public function setValue($value)
    {
        $this->value = $this->parseNumber($value, true);
    }
}
