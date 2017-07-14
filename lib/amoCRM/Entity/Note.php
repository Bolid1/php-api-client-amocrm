<?php

namespace amoCRM\Entity;

use amoCRM\Exception\ValidateException;

/**
 * Class Note
 * @package amoCRM\Entity
 */
class Note
{
    const TYPE_SINGLE = 'note';
    const TYPE_MANY = 'notes';

    const N_TYPE_LEAD_CREATED = 1;
    const N_TYPE_CONTACT_CREATED = 2;
    const N_TYPE_LEAD_STATUS_CHANGED = 3;
    const N_TYPE_COMMON = 4;
    const N_TYPE_FILE = 5;
    const N_TYPE_IPHONE_CALL = 6;
    const N_TYPE_CALL_IN = 10;
    const N_TYPE_CALL_OUT = 11;
    const N_TYPE_COMPANY_CREATED = 12;
    const N_TYPE_TASK_RESULT = 13;
    const N_TYPE_CUSTOMER_CREATED = 22;

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
    private $type = self::N_TYPE_COMMON;
    /** @var string */
    private $text;
    /** @var integer */
    private $responsible;
    /** @var integer */
    private $created_by;

    /**
     * @param integer $note_type
     * @throws \amoCRM\Exception\ValidateException
     */
    public static function ensureValidType($note_type)
    {
        if (!in_array($note_type, self::getTypes(), true)) {
            throw new ValidateException(sprintf('Invalid note type "%s"', $note_type));
        }
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        return [
            self::N_TYPE_LEAD_CREATED,
            self::N_TYPE_CONTACT_CREATED,
            self::N_TYPE_LEAD_STATUS_CHANGED,
            self::N_TYPE_COMMON,
            self::N_TYPE_FILE,
            self::N_TYPE_IPHONE_CALL,
            self::N_TYPE_CALL_IN,
            self::N_TYPE_CALL_OUT,
            self::N_TYPE_COMPANY_CREATED,
            self::N_TYPE_TASK_RESULT,
            self::N_TYPE_CUSTOMER_CREATED,
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
            'note_type' => $this->type,
            'date_create' => $this->date_create,
            'last_modified' => $this->date_modify,
            'modified_user_id' => $this->modified_by,
            'text' => $this->text,
            'responsible_user_id' => $this->responsible,
            'created_user_id' => $this->created_by,
        ];

        return array_filter($result);
    }
}
