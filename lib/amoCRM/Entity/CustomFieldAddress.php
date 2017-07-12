<?php

namespace amoCRM\Entity;

/**
 * Class CustomFieldAddress
 * @package amoCRM\Entity
 */
final class CustomFieldAddress extends CustomFieldSingleValue
{
    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = (string)$value;
    }
}
