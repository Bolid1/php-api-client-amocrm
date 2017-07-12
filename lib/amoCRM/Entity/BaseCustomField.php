<?php

namespace amoCRM\Entity;

use amoCRM\Exception;

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
     * @throws \amoCRM\Exception\InvalidArgumentException
     */
    public function __construct($id)
    {
        $this->setId($id);
    }

    /**
     * @param integer $id
     * @throws Exception\InvalidArgumentException
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
     * @throws Exception\InvalidArgumentException
     */
    protected function parseNumber($int, $can_be_equal_zero = false, $can_be_less_zero = false)
    {
        $this->ensureIsNumeric($int);

        $tmp = (int)$int;
        if ($can_be_less_zero !== true) {
            $this->ensureGreaterOrEqualZero($int, $tmp);
        }

        if ($can_be_equal_zero !== true) {
            $this->ensureNotEqualZero($int, $tmp);
        }

        return $tmp;
    }

    /**
     * @param $int
     * @throws Exception\InvalidArgumentException
     */
    private function ensureIsNumeric($int)
    {
        if (!is_numeric($int)) {
            throw new Exception\InvalidArgumentException(sprintf('"%s" is not a number', $int));
        }
    }

    /**
     * @param $int
     * @param $tmp
     * @throws Exception\InvalidArgumentException
     */
    protected function ensureGreaterOrEqualZero($int, $tmp)
    {
        if ($tmp < 0) {
            throw new Exception\InvalidArgumentException(sprintf('"%s" is less zero', $int));
        }
    }

    /**
     * @param $int
     * @param $tmp
     * @throws Exception\InvalidArgumentException
     */
    protected function ensureNotEqualZero($int, $tmp)
    {
        if ($tmp === 0) {
            throw new Exception\InvalidArgumentException(sprintf('"%s" is equal zero', $int));
        }
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
