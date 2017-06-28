<?php

namespace amoCRM\Unsorted\UnsortedFormFields;

/**
 * Class FormFieldMultiText
 * @package amoCRM\Unsorted\UnsortedFormFields
 */
final class FormFieldMultiText extends BaseFormField
{
    const TYPE = 'multitext';

    public function __construct($id, $element_type)
    {
        parent::__construct($id, self::TYPE, $element_type);
    }

    public function setValue($value)
    {
        $values = $this->getValue() ?: [];
        foreach ((array)$value as $v) {
            $values[] = $v;
        }

        parent::setValue($values);
    }
}
