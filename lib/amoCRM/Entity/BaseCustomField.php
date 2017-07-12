<?php

namespace amoCRM\Entity;

use amoCRM\Validator\NumberValidator;

/**
 * Class BaseCustomField
 * @package amoCRM\Entity
 * Describe common behaviour for custom fields
 */
abstract class BaseCustomField
{
    /** @var integer */
    private $id;

    /**
     * BaseCustomField constructor.
     * @param integer $id
     * @throws \amoCRM\Exception\ValidateException
     */
    public function __construct($id)
    {
        $this->setId($id);
    }

    /**
     * @param integer $id
     * @throws \amoCRM\Exception\ValidateException
     */
    private function setId($id)
    {
        $this->id = NumberValidator::parseInteger($id);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Prepare element for sending to amoCRM
     *
     * @return array
     */
    public function toAmo()
    {
        return ['id' => $this->id, 'values' => $this->valueToAmo()];
    }

    /**
     * @return array
     */
    abstract protected function valueToAmo();
}
