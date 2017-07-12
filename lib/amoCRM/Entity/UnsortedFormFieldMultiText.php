<?php

namespace amoCRM\Entity;

/**
 * Class FormFieldMultiText
 * @package amoCRM\Entity
 */
final class UnsortedFormFieldMultiText extends BaseUnsortedFormField
{
    const TYPE = 'multitext';

    public function __construct($id, $element_type)
    {
        parent::__construct($id, self::TYPE, $element_type);
    }

    /**
     * @param string|array $value
     */
    public function setValue($value)
    {
        $values = $this->getValue() ?: [];
        foreach ((array)$value as $v) {
            $values[] = $v;
        }

        parent::setValue($values);
    }
}
