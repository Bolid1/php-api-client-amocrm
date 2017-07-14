<?php

namespace amoCRM\Entity;

use amoCRM\Exception\ValidateException;
use amoCRM\Parser\DateParser;
use amoCRM\Parser\NumberParser;

/**
 * Class Task
 * @package amoCRM\Entity
 */
class Task
{
    const TYPE_NUMERIC = 4;

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
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setStatus($status)
    {
        $this->ensureValidStatus($status);
        $this->status = $status;
    }

    /**
     * @param $status
     * @throws ValidateException
     */
    private function ensureValidStatus($status)
    {
        if (!in_array($status, self::getStatuses(), true)) {
            throw new ValidateException(sprintf('Invalid status "%s"', $status));
        }
    }

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
        $this->type = $type;
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
     * @return int
     */
    public function getCompleteTill()
    {
        return $this->complete_till;
    }

    /**
     * @param int $complete_till
     * @throws \amoCRM\Exception\InvalidArgumentException
     */
    public function setCompleteTill($complete_till)
    {
        $this->complete_till = DateParser::parseDate($complete_till);
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
