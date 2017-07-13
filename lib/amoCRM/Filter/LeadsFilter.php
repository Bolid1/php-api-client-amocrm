<?php

namespace amoCRM\Filter;

use amoCRM\Parser\NumberParser;

/**
 * Class LeadsFilter
 * @link https://developers.amocrm.ru/rest_api/leads_list.php
 * @package amoCRM\Filter
 */
final class LeadsFilter extends BaseEntityFilter
{
    /** @var array */
    private $status = [];

    /**
     * @param array|integer $status
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setStatus($status)
    {
        $this->status = NumberParser::parseIntegersArray((array)$status);
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
