<?php

namespace amoCRM\Unsorted\UnsortedFormFields;

use amoCRM\Entities\Elements;
use amoCRM\Exceptions\InvalidArgumentException;

/**
 * Class BaseFormField
 * @package amoCRM\Unsorted\UnsortedFormFields
 */
abstract class BaseFormField
{
    /** @var integer */
    private $_id;

    /** @var string */
    private $_type;

    /** @var integer */
    private $_element_type;

    /** @var string */
    private $_name;

    /** @var mixed */
    private $_value;

    /**
     * BaseFormField constructor.
     * @param int $id
     * @param string $type
     * @param integer $element_type
     */
    public function __construct($id, $type, $element_type)
    {
        $this->setId($id);
        $this->setType($type);
        $this->setElementType($element_type);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param int $id
     */
    private function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @param string $type
     */
    private function setType($type)
    {
        $this->_type = $type;
    }

    /**
     * @return int
     */
    public function getElementType()
    {
        return $this->_element_type;
    }

    /**
     * @param int $element_type
     * @throws InvalidArgumentException
     */
    private function setElementType($element_type)
    {
        $available_element_types = [
            Elements\Contact::TYPE_NUMERIC,
            Elements\Lead::TYPE_NUMERIC,
        ];

        if (!in_array($element_type, $available_element_types, true)) {
            throw new InvalidArgumentException(sprintf('Incorrect element type "%s"', $element_type));
        }

        $this->_element_type = $element_type;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * @return array
     */
    public function toAmo()
    {
        return [
            'id' => $this->getId(),
            'type' => $this->getType(),
            'element_type' => $this->getElementType(),
            'name' => $this->getName(),
            'value' => $this->getValue(),
        ];
    }

    public function setValue($value) {
        $this->_value = $value;
    }
}
