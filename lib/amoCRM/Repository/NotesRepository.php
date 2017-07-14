<?php

namespace amoCRM\Repository;

use amoCRM\Entity\Note;
use amoCRM\Service\Interfaces\RequesterService;

/**
 * Class NotesRepository
 * @package amoCRM\Repository
 */
class NotesRepository extends BaseEntityRepository
{
    public function __construct(RequesterService $_requester)
    {
        $names = [
            'many' => Note::TYPE_MANY,
        ];

        $paths = [
            'set' => Note::TYPE_MANY.'/set',
            'list' => Note::TYPE_MANY.'/list',
        ];

        parent::__construct($_requester, $names, $paths);
    }
}
