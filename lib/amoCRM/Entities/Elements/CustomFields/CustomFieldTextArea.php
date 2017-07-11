<?php

namespace amoCRM\Entities\Elements\CustomFields;

/**
 * Class CustomFieldTextArea
 * @package amoCRM\Entities\Elements\CustomFields
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
