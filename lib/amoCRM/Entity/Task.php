<?php

namespace amoCRM\Entity;

/**
 * Class Task
 * @package amoCRM\Entity
 */
class Task
{
    const TYPE_SINGLE = 'task';
    const TYPE_MANY = 'tasks';
    const STATUS_INCOMPLETE = 0;
    const STATUS_COMPLETE = 1;

    /** @var integer */
    private $id;
    /** @var integer */
    private $element_id;
    /** @var integer */
    private $element_type;
    /** @var integer */
    private $date_create;
    /** @var integer */
    private $date_modify;
    /** @var integer */
    private $modified_by;
    /** @var integer */
    private $status = self::STATUS_INCOMPLETE;
    /** @var integer */
    private $type;
    /** @var string */
    private $text;
    /** @var integer */
    private $responsible;
    /** @var integer */
    private $created_by;
    /** @var integer */
    private $complete_till;

    /**
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_INCOMPLETE,
            self::STATUS_COMPLETE,
        ];
    }

    /**
     * Prepare note for sending to amoCRM
     * @return array
     */
    public function toAmo()
    {
        $result = [
            'id' => $this->id,
            'element_id' => $this->element_id,
            'element_type' => $this->element_type,
            'date_create' => $this->date_create,
            'last_modified' => $this->date_modify,
            'modified_user_id' => $this->modified_by,
            'status' => $this->status,
            'task_type' => $this->type,
            'text' => $this->text,
            'responsible_user_id' => $this->responsible,
            'created_user_id' => $this->created_by,
            'complete_till' => $this->complete_till,
        ];

        return array_filter($result);
    }
}
