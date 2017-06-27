<?php

namespace amoCRM\Entities\Elements\CustomFields;

/**
 * Class CustomFieldCheckbox
 * @package amoCRM\Entities\Elements\CustomFields
 * Represents custom field with type checkbox (TRUE or FALSE in other words)
 */
final class CustomFieldCheckbox extends CustomFieldSingleValue
{
    /**
     * @param boolean $value
     */
    public function setValue($value)
    {
        $this->_value = empty($value) ? 0 : 1;
    }
}
