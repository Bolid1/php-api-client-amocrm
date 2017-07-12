<?php

namespace amoCRM\Entity;

/**
 * Class CustomFieldURL
 * @package amoCRM\Entity
 */
final class CustomFieldURL extends CustomFieldSingleValue
{
    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = (string)$value;
    }
}
