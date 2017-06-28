<?php

namespace amoCRM\Unsorted\UnsortedFormFields;

/**
 * Class FormFieldNumber
 * @package amoCRM\Unsorted\UnsortedFormFields
 */
final class FormFieldNumber extends BaseFormField
{
    const TYPE = 'numeric';

    public function __construct($id, $element_type)
    {
        parent::__construct($id, self::TYPE, $element_type);
    }
}
