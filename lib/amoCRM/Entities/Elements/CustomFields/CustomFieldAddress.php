<?php

namespace amoCRM\Entities\Elements\CustomFields;

/**
 * Class CustomFieldAddress
 * @package amoCRM\Entities\Elements\CustomFields
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
