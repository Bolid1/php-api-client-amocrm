<?php

namespace amoCRM\Repository;

use amoCRM\Entity\Task;
use amoCRM\Service\Interfaces\RequesterService;

/**
 * Class TasksRepository
 * @package amoCRM\Repository
 */
class TasksRepository extends BaseEntityRepository
{
    public function __construct(RequesterService $_requester)
    {
        $names = [
            'many' => Task::TYPE_MANY,
        ];

        $paths = [
            'set' => Task::TYPE_MANY.'/set',
            'list' => Task::TYPE_MANY.'/list',
        ];

        parent::__construct($_requester, $names, $paths);
    }
}
