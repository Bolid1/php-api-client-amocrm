<?php

namespace amoCRM\Entity;

use amoCRM\Exception\ValidateException;
use amoCRM\Parser\DateParser;
use amoCRM\Parser\NumberParser;

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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setId($id)
    {
        $this->id = NumberParser::parseInteger($id);
    }

    /**
     * @return int
     */
    public function getElementId()
    {
        return $this->element_id;
    }

    /**
     * @param int $element_id
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setElementId($element_id)
    {
        $this->element_id = NumberParser::parseInteger($element_id);
    }

    /**
     * @return int
     */
    public function getElementType()
    {
        return $this->element_type;
    }

    /**
     * @param int $element_type
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setElementType($element_type)
    {
        $this->ensureValidElementType($element_type);
        $this->element_type = $element_type;
    }

    /**
     * @param integer $element_type
     * @throws ValidateException
     */
    private function ensureValidElementType($element_type)
    {
        $element_types = [
            Contact::TYPE_NUMERIC,
            Lead::TYPE_NUMERIC,
            Company::TYPE_NUMERIC,
            Task::TYPE_NUMERIC,
        ];

        if (!in_array($element_type, $element_types, true)) {
            throw new ValidateException(sprintf('Invalid element type "%s"', $element_type));
        }
    }

    /**
     * @return int
     */
    public function getDateCreate()
    {
        return $this->date_create;
    }

    /**
     * @param int $date_create
     * @throws \amoCRM\Exception\InvalidArgumentException
     */
    public function setDateCreate($date_create)
    {
        $this->date_create = DateParser::parseDate($date_create);
    }

    /**
     * @return int
     */
    public function getDateModify()
    {
        return $this->date_modify;
    }

    /**
     * @param int $date_modify
     * @throws \amoCRM\Exception\InvalidArgumentException
     */
    public function setDateModify($date_modify)
    {
        $this->date_modify = DateParser::parseDate($date_modify);
    }

    /**
     * @return int
     */
    public function getModifiedBy()
    {
        return $this->modified_by;
    }

    /**
     * @param int $modified_by
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setModifiedBy($modified_by)
    {
        $this->modified_by = NumberParser::parseInteger($modified_by);
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setType($type)
    {
        self::ensureValidType($type);
        $this->type = $type;
    }

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
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return int
     */
    public function getResponsible()
    {
        return $this->responsible;
    }

    /**
     * @param int $responsible
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setResponsible($responsible)
    {
        $this->responsible = NumberParser::parseInteger($responsible);
    }

    /**
     * @return int
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * @param int $created_by
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = NumberParser::parseInteger($created_by);
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
