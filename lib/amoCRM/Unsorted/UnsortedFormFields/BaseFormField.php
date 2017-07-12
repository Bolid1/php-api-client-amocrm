<?php

namespace amoCRM\Unsorted\UnsortedFormFields;

use amoCRM\Entity;
use amoCRM\Exception\InvalidArgumentException;

/**
 * Class BaseFormField
 * @package amoCRM\Unsorted\UnsortedFormFields
 */
abstract class BaseFormField
{
    /** @var integer */
    private $id;

    /** @var string */
    private $type;

    /** @var integer */
    private $element_type;

    /** @var string */
    private $name;

    /** @var mixed */
    private $value;

    /**
     * BaseFormField constructor.
     * @param int $id
     * @param string $type
     * @param integer $element_type
     * @throws \amoCRM\Exception\InvalidArgumentException
     */
    public function __construct($id, $type, $element_type)
    {
        $this->setId($id);
        $this->setType($type);
        $this->setElementType($element_type);
    }

    /**
     * @param int $id
     */
    private function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $type
     */
    private function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param int $element_type
     * @throws InvalidArgumentException
     */
    private function setElementType($element_type)
    {
        $available_element_types = [
            Entity\Contact::TYPE_NUMERIC,
            Entity\Lead::TYPE_NUMERIC,
        ];

        if (!in_array($element_type, $available_element_types, true)) {
            throw new InvalidArgumentException(sprintf('Incorrect element type "%s"', $element_type));
        }

        $this->element_type = $element_type;
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

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getElementType()
    {
        return $this->element_type;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

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
}
