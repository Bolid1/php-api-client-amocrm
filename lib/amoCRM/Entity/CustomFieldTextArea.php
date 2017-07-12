<?php

namespace amoCRM\Entity;

/**
 * Class CustomFieldTextArea
 * @package amoCRM\Entity
 */
final class CustomFieldTextArea extends CustomFieldSingleValue
{
    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = (string)$value;
    }
}
