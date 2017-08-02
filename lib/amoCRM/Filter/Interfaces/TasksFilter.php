<?php

namespace amoCRM\Filter\Interfaces;

use amoCRM\Entity;

/**
 * Class TasksFilter
 * Filters for tasks list
 * @package amoCRM\Filter
 */
interface TasksFilter extends SearchFilter
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
    public function setElementType($element_type = Entity\Contact::TYPE_SINGLE);

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
    public function getResponsibleUser();

    /**
     * @param array|integer $responsible_user
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setResponsibleUser($responsible_user);

    /**
     * @return int
     */
    public function getStatus();

    /**
     * @param integer|null $status
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setStatus($status);
}
