<?php

namespace amoCRM\Repository;

use amoCRM\Entity\Contact;
use amoCRM\Service\Interfaces\RequesterService;

/**
 * Class ContactsRepository
 * @package amoCRM\Repository
 */
class ContactsRepository extends BaseEntityRepository
{
    public function __construct(RequesterService $_requester)
    {
        $names = [
            'many' => Contact::TYPE_MANY,
        ];

        $paths = [
            'set' => Contact::TYPE_MANY . '/set',
            'list' => Contact::TYPE_MANY . '/list',
        ];

        parent::__construct($_requester, $names, $paths);
    }
}
