<?php

namespace amoCRM\Entity\Factory;

use amoCRM\Entity\BaseUnsortedFormField;
use amoCRM\Entity\UnsortedFormFieldMultiText;
use amoCRM\Entity\UnsortedFormFieldNumber;
use amoCRM\Entity\UnsortedFormFieldText;
use amoCRM\Exception\InvalidArgumentException;

/**
 * Class FormFieldFactory
 * @package amoCRM\Entity
 */
final class FormFieldFactory
{
    /**
     * @param string $type
     * @param string|integer $id
     * @param integer $element_type
     * @return BaseUnsortedFormField
     * @throws InvalidArgumentException
     */
    public static function make($type, $id, $element_type)
    {
        switch ($type) {
            case UnsortedFormFieldNumber::TYPE:
                return new UnsortedFormFieldNumber($id, $element_type);
            case UnsortedFormFieldText::TYPE:
                return new UnsortedFormFieldText($id, $element_type);
            case UnsortedFormFieldMultiText::TYPE:
                return new UnsortedFormFieldMultiText($id, $element_type);
            default:
                throw new InvalidArgumentException(sprintf('Unknown field type "%s"', $type));
        }
    }
}
