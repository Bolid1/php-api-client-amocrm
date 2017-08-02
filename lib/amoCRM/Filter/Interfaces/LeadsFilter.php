<?php

namespace amoCRM\Filter\Interfaces;

/**
 * Class LeadsFilter
 * @link https://developers.amocrm.ru/rest_api/leads_list.php
 * @package amoCRM\Filter\Interfaces
 */
interface LeadsFilter extends BaseEntityFilter
{
    /**
     * @param array|integer $status
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setStatus($status);
}
