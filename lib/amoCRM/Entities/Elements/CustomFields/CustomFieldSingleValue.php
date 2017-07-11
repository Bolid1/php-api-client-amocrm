<?php

namespace amoCRM\Entities\Elements\CustomFields;

abstract class CustomFieldSingleValue extends BaseCustomField
{
    /** @var mixed */
    protected $_value;

    public function setValue($value)
    {
        $this->_value = $value;
    }

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
