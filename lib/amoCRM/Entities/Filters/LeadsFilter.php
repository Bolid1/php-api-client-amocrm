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
    private $status = [];

    /**
     * @param array|integer $status
     * @throws \amoCRM\Exceptions\InvalidArgumentException
     */
    public function setStatus($status)
    {
        $this->status = (array)$status;
        $this->onlyPositiveIntegers($this->status);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = parent::toArray() + ['status' => $this->status];

        return array_filter($result);
    }
}
