<?php

namespace amoCRM\Entities\Elements\CustomFields;

abstract class CustomFieldSingleValue extends BaseCustomField
{
    /** @var mixed */
    protected $_value;

    abstract public function setValue($value);

    /**
     * @return array
     */
    protected function valueToAmo()
    {
        return [
            ['value' => $this->prepareToAmo()],
        ];
    }

    /**
     * @return mixed
     */
    protected function prepareToAmo()
    {
        return $this->_value;
    }
}
