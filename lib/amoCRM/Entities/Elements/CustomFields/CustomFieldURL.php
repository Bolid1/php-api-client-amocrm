<?php

namespace amoCRM\Entities\Elements\CustomFields;

/**
 * Class CustomFieldURL
 * @package amoCRM\Entities\Elements\CustomFields
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
