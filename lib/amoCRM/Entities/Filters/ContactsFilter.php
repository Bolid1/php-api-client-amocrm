<?php

namespace amoCRM\Entities\Filters;


use amoCRM\Entities\Elements\Contact;
use amoCRM\Exceptions\InvalidArgumentException;

/**
 * Class ContactsFilter
 * @link https://developers.amocrm.ru/rest_api/contacts_list.php Parameters
 * @package amoCRM\Entities\Filters
 */
final class ContactsFilter extends BaseEntityFilter
{
    /** @var string */
    private $_type = Contact::TYPE_SINGLE;

    /**
     * @param string $type
     * @throws InvalidArgumentException
     */
    public function setType($type)
    {
        $available_types = [Contact::TYPE_SINGLE, 'company', 'all'];

        if (!in_array($type, $available_types, true)) {
            $message = sprintf(
                'Must on of [%s], but %s given',
                implode(', ', $available_types),
                $type
            );
            throw new InvalidArgumentException($message);
        }

        $this->_type = $type;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = parent::toArray() + ['type' => $this->_type];

        return array_filter($result);
    }
}
