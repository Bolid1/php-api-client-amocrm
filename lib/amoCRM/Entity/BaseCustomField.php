<?php

namespace amoCRM\Entity;

use amoCRM\Exceptions;

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
     * @throws \amoCRM\Exceptions\InvalidArgumentException
     */
    public function __construct($id)
    {
        $this->setId($id);
    }

    /**
     * @param integer $id
     * @throws Exceptions\InvalidArgumentException
     */
    private function setId($id)
    {
        $this->id = $this->parseNumber($id);
    }

    /**
     * @param integer $int
     * @param bool $can_be_equal_zero
     * @param bool $can_be_less_zero
     * @return int
     * @throws Exceptions\InvalidArgumentException
     */
    protected function parseNumber($int, $can_be_equal_zero = false, $can_be_less_zero = false)
    {
        if (!is_numeric($int)) {
            throw new Exceptions\InvalidArgumentException(sprintf('"%s" is not a number', $int));
        }

        $tmp = (int)$int;
        if ($can_be_less_zero !== true && $tmp < 0) {
            throw new Exceptions\InvalidArgumentException(sprintf('"%s" is less zero', $int));
        }

        if ($can_be_equal_zero !== true && $tmp === 0) {
            throw new Exceptions\InvalidArgumentException(sprintf('"%s" is equal zero', $int));
        }

        return $tmp;
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
