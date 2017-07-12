<?php

namespace amoCRM\Entity;

use amoCRM\Exception\InvalidArgumentException;

abstract class CustomFieldMultiText extends BaseCustomField
{
    /** @var array */
    protected $values = [];

    /** @var array */
    protected $enums;

    /**
     * CustomFieldMultiText constructor.
     * @param integer $id
     * @param array $enums
     * @throws \amoCRM\Exception\ValidateException
     */
    public function __construct($id, array $enums)
    {
        parent::__construct($id);
        $this->enums = $enums;
    }

    /**
     * Return available enums of current field
     *
     * @return array
     */
    public function getEnums()
    {
        return $this->enums;
    }

    /**
     * Return available enums of current field
     *
     * @return array
     */
    public function getDefaultEnum()
    {
        return reset($this->enums);
    }

    public function addValue($enum, $value)
    {
        $enum_upper = strtoupper($enum);
        if (!in_array($enum_upper, $this->enums, true)) {
            throw new InvalidArgumentException(sprintf('Invalid enum "%s"', $enum));
        }

        $this->values[] = [
            'enum' => $enum_upper,
            'value' => (string)$value,
        ];
    }

    /**
     * @return array
     */
    protected function valueToAmo()
    {
        return $this->values;
    }
}
