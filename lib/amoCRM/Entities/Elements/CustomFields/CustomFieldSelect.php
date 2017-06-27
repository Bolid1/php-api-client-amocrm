<?php

namespace amoCRM\Entities\Elements\CustomFields;

use amoCRM\Exceptions;

/**
 * Class CustomFieldSelect
 * @package amoCRM\Entities\Elements\CustomFields
 * Represents custom field with select from options
 */
class CustomFieldSelect extends CustomFieldSingleValue
{
    /** @var array */
    protected $_enums;

    /**
     * CustomFieldSelect constructor.
     * @param integer $id
     * @param array $enums
     */
    public function __construct($id, $enums)
    {
        parent::__construct($id);
        foreach ($enums as $enum => $value) {
            $this->_enums[$this->parseNumber($enum)] = (string)$value;
        }
    }

    /**
     * @param string $value
     * @throws Exceptions\InvalidArgumentException
     */
    public function setValue($value)
    {
        $enum = array_search((string)$value, $this->_enums, true);

        if ($enum === false) {
            throw new Exceptions\InvalidArgumentException(sprintf('"%s" is not in enums', $value));
        }

        $this->setEnum($enum);
    }

    /**
     * @param integer $enum
     * @throws Exceptions\InvalidArgumentException
     */
    public function setEnum($enum)
    {
        $this->_value = $this->parseNumber($enum, true);

        if (!isset($this->_enums[$this->_value])) {
            throw new Exceptions\InvalidArgumentException(sprintf('"%s" is not enum of this field', $enum));
        }
    }
}
