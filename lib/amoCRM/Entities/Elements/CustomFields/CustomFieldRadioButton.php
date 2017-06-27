<?php

namespace amoCRM\Entities\Elements\CustomFields;


class CustomFieldRadioButton extends CustomFieldSelect
{
    protected function prepareToAmo()
    {
        return isset($this->_value) ? $this->_enums[$this->_value] : '';
    }
}
