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
    private $id = [];
    /** @var string */
    private $query;
    /** @var array */
    private $responsible_user = [];

    /**
     * @param array|integer $id
     * @throws \amoCRM\Exceptions\InvalidArgumentException
     */
    public function setId($id)
    {

        $this->id = (array)$id;
        $this->onlyPositiveIntegers($this->id);
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
        $this->query = (string)$query;
    }

    /**
     * @param array|integer $responsible_user
     * @throws \amoCRM\Exceptions\InvalidArgumentException
     */
    public function setResponsibleUser($responsible_user)
    {
        $this->responsible_user = (array)$responsible_user;
        $this->onlyPositiveIntegers($this->responsible_user);
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
