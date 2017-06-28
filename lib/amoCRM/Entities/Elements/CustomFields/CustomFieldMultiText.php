<?php

namespace amoCRM\Entities\Elements\CustomFields;

use amoCRM\Exceptions\InvalidArgumentException;

abstract class CustomFieldMultiText extends BaseCustomField
{
    /** @var array */
    protected $_values = [];

    /** @var array */
    protected $_enums;

    /**
     * CustomFieldMultiText constructor.
     * @param integer $id
     * @param array $enums
     */
    public function __construct($id, array $enums)
    {
        parent::__construct($id);
        $this->_enums = $enums;
    }

    /**
     * Return available enums of current field
     *
     * @return array
     */
    public function getEnums()
    {
        return $this->_enums;
    }

    public function addValue($enum, $value)
    {
        $enum_upper = strtoupper($enum);
        if (!in_array($enum_upper, $this->_enums, true)) {
            throw new InvalidArgumentException(sprintf('Invalid enum "%s"', $enum));
        }

        $this->_values[] = [
            'enum' => $enum_upper,
            'value' => (string)$value,
        ];
    }

    /**
     * @return array
     */
    protected function valueToAmo()
    {
        return $this->_values;
    }
}
