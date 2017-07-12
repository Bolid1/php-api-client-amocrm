<?php

namespace amoCRM\Entity;

/**
 * Class CustomFieldCheckbox
 * @package amoCRM\Entity
 * Represents custom field with type checkbox (TRUE or FALSE in other words)
 */
final class CustomFieldCheckbox extends CustomFieldSingleValue
{
    /**
     * @param boolean $value
     */
    public function setValue($value)
    {
        $this->value = empty($value) ? 0 : 1;
    }
}
