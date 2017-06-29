<?php

namespace amoCRM\Entities\Filters;

use amoCRM\Exceptions\InvalidArgumentException;

/**
 * Class BaseEntityFilter
 * Common methods for filters
 * @package amoCRM\Entities\Filters
 */
abstract class BaseEntityFilter implements Interfaces\SearchFilter
{
    /** @var array */
    private $_id = [];
    /** @var string */
    private $_query;
    /** @var array */
    private $_responsible_user = [];

    /**
     * @param array|integer $id
     */
    public function setId($id)
    {

        $this->_id = (array)$id;
        $this->onlyPositiveIntegers($this->_id);
    }

    /**
     * @param array $array
     * @throws InvalidArgumentException
     */
    protected function onlyPositiveIntegers(array $array)
    {
        $options = [
            'options' => [
                'min_range' => 1,
            ]
        ];

        foreach ($array as $item) {
            if (!filter_var($item, FILTER_VALIDATE_INT, $options)) {
                $message = sprintf('Must be greater than zero, "%s" given', $item);
                throw new InvalidArgumentException($message);
            }
        }
    }

    /**
     * @param string $query
     */
    public function setQuery($query)
    {
        $this->_query = (string)$query;
    }

    /**
     * @param array|integer $responsible_user
     */
    public function setResponsibleUser($responsible_user)
    {
        $this->_responsible_user = (array)$responsible_user;
        $this->onlyPositiveIntegers($this->_responsible_user);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [
            'id' => $this->_id,
            'query' => $this->_query,
            'responsible_user_id' => $this->_responsible_user,
        ];

        return array_filter($result);
    }
}
