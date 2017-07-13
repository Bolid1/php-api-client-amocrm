<?php

namespace amoCRM\Filter;

use amoCRM\Validator\NumberValidator;

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
        $this->status = NumberValidator::parseIntegersArray((array)$status);
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
