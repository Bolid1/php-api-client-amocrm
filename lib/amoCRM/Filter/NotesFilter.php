<?php

namespace amoCRM\Filter;

use amoCRM\Entity;
use amoCRM\Exception\ValidateException;
use amoCRM\Parser\NumberParser;

/**
 * Class NotesFilter
 * Filters for notes list
 * @package amoCRM\Filter
 */
final class NotesFilter implements Interfaces\NotesFilter
{
    const ELEMENT_TYPE_CONTACT = Entity\Contact::TYPE_SINGLE;
    const ELEMENT_TYPE_LEAD = Entity\Lead::TYPE_SINGLE;
    const ELEMENT_TYPE_COMPANY = Entity\Company::TYPE_SINGLE;
    const ELEMENT_TYPE_TASK = Entity\Task::TYPE_SINGLE;

    /** @var string */
    private $element_type = self::ELEMENT_TYPE_CONTACT;
    /** @var array.<int> */
    private $element_id = [];
    /** @var array.<int> */
    private $id = [];
    /** @var array.<int> */
    private $notes_type = [];

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
    public function setElementType($element_type = self::ELEMENT_TYPE_CONTACT)
    {
        $this->ensureValidElementType($element_type);
        $this->element_type = $element_type;
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
            self::ELEMENT_TYPE_CONTACT,
            self::ELEMENT_TYPE_LEAD,
            self::ELEMENT_TYPE_COMPANY,
            self::ELEMENT_TYPE_TASK,
        ];
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
    public function getNotesType()
    {
        return $this->notes_type;
    }

    /**
     * @param array|integer|null $notes_type
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setNotesType($notes_type)
    {
        $notes_types = (array)$notes_type;
        array_map(['\amoCRM\Entity\Note', 'ensureValidType'], $notes_types);
        $this->notes_type = $notes_types;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [
            'id' => $this->id,
            'type' => $this->element_type,
            'element_id' => $this->element_id,
            'note_type' => $this->notes_type,
        ];

        return array_filter($result);
    }
}
