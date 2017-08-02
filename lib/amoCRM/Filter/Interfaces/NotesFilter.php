<?php

namespace amoCRM\Filter\Interfaces;

/**
 * Class NotesFilter
 * Filters for notes list
 * @package amoCRM\Filter\Intefaces
 */
interface NotesFilter extends SearchFilter
{
    /**
     * @return array
     */
    public function getId();

    /**
     * @param array|integer $id
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getElementType();

    /**
     * @param string [$element_type = 'contact']
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setElementType($element_type = \amoCRM\Filter\NotesFilter::ELEMENT_TYPE_CONTACT);

    /**
     * @return array
     */
    public function getElementId();

    /**
     * @param array|integer $element_id
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setElementId($element_id);

    /**
     * @return array
     */
    public function getNotesType();

    /**
     * @param array|integer|null $notes_type
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setNotesType($notes_type);
}
