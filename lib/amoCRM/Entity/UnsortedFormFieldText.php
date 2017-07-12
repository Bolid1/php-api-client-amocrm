<?php

namespace amoCRM\Entity;

/**
 * Class FormFieldText
 * @package amoCRM\Entity
 */
final class UnsortedFormFieldText extends BaseUnsortedFormField
{
    const TYPE = 'text';

    public function __construct($id, $element_type)
    {
        parent::__construct($id, self::TYPE, $element_type);
    }
}
