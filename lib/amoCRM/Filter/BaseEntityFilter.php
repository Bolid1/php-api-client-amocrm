<?php

namespace amoCRM\Filter;

use amoCRM\Validator\NumberValidator;

/**
 * Class BaseEntityFilter
 * Common methods for filters
 * @package amoCRM\Filter
 */
abstract class BaseEntityFilter implements Interfaces\SearchFilter
{
    /** @var array */
    private $id = [];
    /** @var string */
    private $query;
    /** @var array */
    private $responsible_user = [];

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
        $this->id = NumberValidator::parseIntegersArray((array)$id);
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param string $query
     */
    public function setQuery($query)
    {
        $this->query = (string)$query;
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
        $this->responsible_user = NumberValidator::parseIntegersArray((array)$responsible_user);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [
            'id' => $this->id,
            'query' => $this->query,
            'responsible_user_id' => $this->responsible_user,
        ];

        return array_filter($result);
    }
}
