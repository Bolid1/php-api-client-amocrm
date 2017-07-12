<?php

namespace amoCRM\Unsorted\UnsortedFormFields;

use amoCRM\Exception\InvalidArgumentException;

/**
 * Class FormFieldFactory
 * @package amoCRM\Unsorted\UnsortedFormFields
 */
final class FormFieldFactory
{
    /**
     * @param string $type
     * @param string|integer $id
     * @param integer $element_type
     * @return BaseFormField
     * @throws InvalidArgumentException
     */
    public static function make($type, $id, $element_type)
    {
        switch ($type) {
            case FormFieldNumber::TYPE:
                return new FormFieldNumber($id, $element_type);
            case FormFieldText::TYPE:
                return new FormFieldText($id, $element_type);
            case FormFieldMultiText::TYPE:
                return new FormFieldMultiText($id, $element_type);
            default:
                throw new InvalidArgumentException(sprintf('Unknown field type "%s"', $type));
        }
    }
}
