<?php

namespace amoCRM\Filter;

use amoCRM\Entity\Company;
use amoCRM\Entity\Contact;
use amoCRM\Exception\InvalidArgumentException;

/**
 * Class ContactsFilter
 * @link https://developers.amocrm.ru/rest_api/contacts_list.php Parameters
 * @package amoCRM\Filter
 */
final class ContactsFilter extends BaseEntityFilter implements Interfaces\ContactsFilter
{
    /** @var string */
    private $type = Contact::TYPE_SINGLE;

    /**
     * @param string $type
     * @throws InvalidArgumentException
     */
    public function setType($type)
    {
        $available_types = [Contact::TYPE_SINGLE, Company::TYPE_SINGLE, 'all'];

        if (!in_array($type, $available_types, true)) {
            $message = sprintf(
                'Must on of [%s], but %s given',
                implode(', ', $available_types),
                $type
            );
            throw new InvalidArgumentException($message);
        }

        $this->type = $type;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = parent::toArray() + ['type' => $this->type];

        return array_filter($result);
    }
}
