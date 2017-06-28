<?php

namespace amoCRM\Unsorted\UnsortedFormFields;

/**
 * Class FormFieldText
 * @package amoCRM\Unsorted\UnsortedFormFields
 */
final class FormFieldText extends BaseFormField
{
    const TYPE = 'text';

    public function __construct($id, $element_type)
    {
        parent::__construct($id, self::TYPE, $element_type);
    }
}
