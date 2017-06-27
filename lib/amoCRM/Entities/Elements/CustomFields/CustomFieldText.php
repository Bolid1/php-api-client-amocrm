<?php

namespace amoCRM\Entities\Elements\CustomFields;

/**
 * Class CustomFieldText
 * @package amoCRM\Entities\Elements\CustomFields
 * Represents custom field of type Text
 */
class CustomFieldText extends CustomFieldSingleValue
{
    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->_value = (string)$value;
    }
}
