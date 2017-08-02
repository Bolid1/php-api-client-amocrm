<?php

namespace amoCRM\Filter\Interfaces;

use amoCRM\Exception\InvalidArgumentException;

/**
 * Class ContactsFilter
 * @link https://developers.amocrm.ru/rest_api/contacts_list.php Parameters
 * @package amoCRM\Filter\Interfaces
 */
interface ContactsFilter extends BaseEntityFilter
{
    /**
     * @param string $type
     * @throws InvalidArgumentException
     */
    public function setType($type);
}
