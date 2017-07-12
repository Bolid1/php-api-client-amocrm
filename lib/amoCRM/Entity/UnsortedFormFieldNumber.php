<?php

namespace amoCRM\Entity;

/**
 * Class FormFieldNumber
 * @package amoCRM\Entity
 */
final class UnsortedFormFieldNumber extends BaseUnsortedFormField
{
    const TYPE = 'numeric';

    public function __construct($id, $element_type)
    {
        parent::__construct($id, self::TYPE, $element_type);
    }
}
