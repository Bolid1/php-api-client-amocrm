<?php

namespace amoCRM\Entity;

abstract class CustomFieldSingleValue extends BaseCustomField
{
    /** @var mixed */
    protected $value;

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
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
        return $this->value;
    }
}
