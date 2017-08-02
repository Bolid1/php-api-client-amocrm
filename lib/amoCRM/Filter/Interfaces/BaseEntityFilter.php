<?php

namespace amoCRM\Filter\Interfaces;

/**
 * Class BaseEntityFilter
 * Common methods for filters
 * @package amoCRM\Filter\Interfaces
 */
interface BaseEntityFilter extends SearchFilter
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
    public function getQuery();

    /**
     * @param string $query
     */
    public function setQuery($query);

    /**
     * @return array
     */
    public function getResponsibleUser();

    /**
     * @param array|integer $responsible_user
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setResponsibleUser($responsible_user);
}
