<?php

namespace amoCRM\Entities\Filters;

/**
 * Class LeadsFilter
 * @link https://developers.amocrm.ru/rest_api/leads_list.php
 * @package amoCRM\Entities\Filters
 */
final class LeadsFilter extends BaseEntityFilter
{
    /** @var array */
    private $_status = [];

    /**
     * @param array|integer $status
     */
    public function setStatus($status)
    {
        $this->_status = (array)$status;
        $this->onlyPositiveIntegers($this->_status);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = parent::toArray() + ['status' => $this->_status];

        return array_filter($result);
    }
}
