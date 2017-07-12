<?php

namespace amoCRM\Entity;

/**
 * Class CustomFieldText
 * @package amoCRM\Entity
 * Represents custom field of type Text
 */
class CustomFieldText extends CustomFieldSingleValue
{
    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = (string)$value;
    }
}
