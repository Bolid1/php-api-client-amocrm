<?php

namespace amoCRM\Filter;

use amoCRM\Entity;
use amoCRM\Exception\ValidateException;
use amoCRM\Parser\NumberParser;

/**
 * Class TasksFilter
 * Filters for tasks list
 * @package amoCRM\Filter
 */
final class TasksFilter implements Interfaces\SearchFilter
{
    /** @var string */
    private $element_type = Entity\Contact::TYPE_SINGLE;
    /** @var array.<int> */
    private $element_id = [];
    /** @var array.<int> */
    private $id = [];
    /** @var array.<int> */
    private $responsible_user = [];
    /** @var integer */
    private $status;

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [
            'id' => $this->getId(),
            'type' => $this->getElementType(),
            'element_id' => $this->getElementId(),
            'responsible_user_id' => $this->getResponsibleUser(),
        ];

        $result = array_filter($result);

        if (in_array($this->getStatus(), Entity\Task::getStatuses(), true)) {
            $result['filter']['status'] = $this->getStatus();
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param array|integer $id
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setId($id)
    {
        $this->id = NumberParser::parseIntegersArray((array)$id);
    }

    /**
     * @return string
     */
    public function getElementType()
    {
        return $this->element_type;
    }

    /**
     * @param string [$element_type = 'contact']
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setElementType($element_type = Entity\Contact::TYPE_SINGLE)
    {
        $this->ensureValidElementType($element_type);
        $this->element_type = $element_type;
    }

    /**
     * @return array
     */
    public function getElementId()
    {
        return $this->element_id;
    }

    /**
     * @param array|integer $element_id
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setElementId($element_id)
    {
        $this->element_id = NumberParser::parseIntegersArray((array)$element_id);
    }

    /**
     * @return array
     */
    public function getResponsibleUser()
    {
        return $this->responsible_user;
    }

    /**
     * @param array|integer $responsible_user
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setResponsibleUser($responsible_user)
    {
        $this->responsible_user = NumberParser::parseIntegersArray((array)$responsible_user);
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $element_type
     * @throws \amoCRM\Exception\ValidateException
     */
    private function ensureValidElementType($element_type)
    {
        if (!in_array($element_type, self::getElementTypes(), true)) {
            throw new ValidateException(sprintf('Invalid element type "%s"', $element_type));
        }
    }

    /**
     * @return array
     */
    public static function getElementTypes()
    {
        return [
            Entity\Contact::TYPE_SINGLE,
            Entity\Lead::TYPE_SINGLE,
            Entity\Company::TYPE_SINGLE,
        ];
    }

    /**
     * @param integer|null $status
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setStatus($status)
    {
        $this->ensureValidStatus($status);
        $this->status = $status;
    }

    /**
     * @param string $status
     * @throws \amoCRM\Exception\ValidateException
     */
    private function ensureValidStatus($status)
    {
        if ($status !== null && !in_array($status, Entity\Task::getStatuses(), true)) {
            throw new ValidateException(sprintf('Invalid statuses "%s"', $status));
        }
    }
}
