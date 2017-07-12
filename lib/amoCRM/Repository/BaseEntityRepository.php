<?php

namespace amoCRM\Repository;

use amoCRM\Exceptions;
use amoCRM\Filter\Interfaces\SearchFilter;
use amoCRM\Interfaces\Requester;

/**
 * Class BaseEntityRequester
 * @package amoCRM\Entities
 * Base class for amoCRM entities requests manager
 */
abstract class BaseEntityRepository
{
    /** @var  Requester */
    private $requester;

    /** @var array */
    private $names = [
        'many' => null,
    ];

    /** @var array */
    private $paths = [
        'set' => null,
        'list' => null,
    ];

    /**
     * BaseEntityRequester constructor.
     * @param Requester $_requester
     * @param array $names
     * @param array $paths
     * @throws Exceptions\InvalidArgumentException
     */
    public function __construct(Requester $_requester, array $names, array $paths)
    {
        $this->requester = $_requester;

        $this->setNames($names);
        $this->setPaths($paths);
    }

    /**
     * @param array $names
     * @throws Exceptions\InvalidArgumentException
     */
    private function setNames(array $names)
    {
        foreach ($this->names as $key => &$name) {
            if (empty($names[$key])) {
                throw new Exceptions\InvalidArgumentException(sprintf('Empty name "%s"', $key));
            }
            $name = $names[$key];
        }
        unset($name);
    }

    /**
     * @param array $paths
     * @throws Exceptions\InvalidArgumentException
     */
    private function setPaths(array $paths)
    {
        foreach ($this->paths as $key => &$path) {
            if (empty($paths[$key])) {
                throw new Exceptions\InvalidArgumentException(sprintf('Empty path "%s"', $key));
            }
            $path = Requester::API_PATH . $paths[$key];
        }
        unset($path);
    }

    /**
     * Request for add many elements
     *
     * @param array $elements
     * @return array
     * @throws \amoCRM\Exceptions\InvalidArgumentException
     */
    public function add(array $elements)
    {
        $this->ensureIsArrayOfElements($elements);

        return $this->set($elements, 'add');
    }

    /**
     * Check for possible wrong nesting level
     *
     * @param array $elements
     * @throws Exceptions\InvalidArgumentException
     */
    private function ensureIsArrayOfElements(array $elements)
    {
        foreach ($elements as $element) {
            if (!is_array($element)) {
                $message = sprintf('Element "%s" is not an array', var_export($element, true));
                throw new Exceptions\InvalidArgumentException($message);
            }
        }
    }

    /**
     * @param array $elements
     * @param string $action
     * @return array
     */
    private function set(array $elements, $action)
    {
        $data = [
            'request' => [
                $this->names['many'] => [
                    $action => $elements,
                ],
            ],
        ];

        /**
         * На данный момент $result выглядит так:
         * 'response' => [
         *   $this->_names['many'] => [
         *     $action => $elements,
         *   ],
         * ],
         */
        $result = $this->requester->post($this->paths['set'], $data);

        if (isset($result[$this->names['many']])) {
            $result = $result[$this->names['many']];
        }

        if (isset($result[$action])) {
            $result = $result[$action];
        }

        return $result;
    }

    /**
     * Request for add many elements
     *
     * @param array $elements
     * @return array
     * @throws \amoCRM\Exceptions\InvalidArgumentException
     */
    public function update(array $elements)
    {
        $this->ensureIsArrayOfElements($elements);
        $this->ensureIsArrayOfElementsWithIds($elements);

        return $this->set($elements, 'update');
    }

    /**
     * Check for possible invalid data format
     *
     * @param array $elements
     * @throws Exceptions\InvalidArgumentException
     */
    private function ensureIsArrayOfElementsWithIds(array $elements)
    {
        foreach ($elements as $element) {
            if (!isset($element['id']) || !is_numeric($element['id'])) {
                $message = sprintf('Element "%s" without numeric id', var_export($element, true));
                throw new Exceptions\InvalidArgumentException($message);
            }
        }
    }

    /**
     * Method for use elements/list endpoints
     *
     * @param SearchFilter $filter
     * @param array $nav
     *
     * @return array
     * @throws \amoCRM\Exceptions\InvalidArgumentException
     */
    public function search(SearchFilter $filter = null, array $nav = [])
    {
        $query = [];

        if ($nav = $this->parseNavigation($nav)) {
            $query = array_merge($query, $nav);
        }

        if ($filter !== null) {
            $query = array_merge($query, $filter->toArray());
        }

        $result = $this->requester->get($this->paths['list'], $query) ?: [];

        if (isset($result[$this->names['many']])) {
            $result = $result[$this->names['many']];
        }

        return $result;
    }

    /**
     * Parse navigation array
     *
     * @param array $nav
     * @return array
     * @throws Exceptions\InvalidArgumentException
     */
    private function parseNavigation(array $nav)
    {
        $names_match = [
            'limit' => 'limit_rows',
            'offset' => 'limit_offset',
        ];
        $result = [];
        foreach (['limit', 'offset'] as $field) {
            if (!isset($nav[$field])) {
                continue;
            }

            $value = (int)$nav[$field];

            // Offset and limit can't be less zero
            if ($value < 0) {
                $message = sprintf('Invalid navigation field "%s" value: "%s"', $field, $nav[$field]);
                throw new Exceptions\InvalidArgumentException($message);
            }

            // Limit must be between 1 and 500
            if (($value > 500 || $value === 0) && $field === 'limit') {
                $message = sprintf('Invalid navigation field "%s" value: "%s"', $field, $nav[$field]);
                throw new Exceptions\InvalidArgumentException($message);
            }

            $result[$names_match[$field]] = $value;
        }

        return $result;
    }
}
