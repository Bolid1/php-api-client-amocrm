<?php

namespace amoCRM\Entities;

use amoCRM\Entities\Filters\Interfaces\SearchFilter;
use amoCRM\Exceptions;
use amoCRM\Interfaces\Requester;

/**
 * Class BaseEntityRequester
 * @package amoCRM\Entities
 * Base class for amoCRM entities requests manager
 */
abstract class BaseEntityRequester
{
    /** @var  Requester */
    private $_requester;

    /** @var array */
    private $_names = [
        'many' => null,
    ];

    /** @var array */
    private $_paths = [
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
        $this->_requester = $_requester;

        $this->setNames($names);
        $this->setPaths($paths);
    }

    /**
     * @param array $names
     * @throws Exceptions\InvalidArgumentException
     */
    private function setNames(array $names)
    {
        foreach ($this->_names as $key => &$name) {
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
        foreach ($this->_paths as $key => &$path) {
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
     */
    public function add(array $elements)
    {
        $this->ensureIsArrayOfElements($elements);

        $data = [
            'request' => [
                $this->_names['many'] => [
                    'add' => $elements,
                ],
            ],
        ];

        /**
         * На данный момент $result выглядит так:
         * 'response' => [
         *   $this->_names['many'] => [
         *     'add' => $elements,
         *   ],
         * ],
         */
        $result = $this->_requester->post($this->_paths['set'], $data);

        if (isset($result[$this->_names['many']])) {
            $result = $result[$this->_names['many']];
        }

        if (isset($result['add'])) {
            $result = $result['add'];
        }

        return $result;
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
     * Method for use elements/list endpoints
     *
     * @param SearchFilter $filter
     * @param array $nav
     *
     * @return array
     */
    public function search(SearchFilter $filter = null, array $nav = [])
    {
        $query = [];

        if ($nav = $this->parseNavigation($nav)) {
            $query += $nav;
        }

        if (!is_null($filter)) {
            $query += $filter->toArray();
        }

        $result = $this->_requester->get($this->_paths['list'], $query) ?: [];

        if (isset($result[$this->_names['many']])) {
            $result = $result[$this->_names['many']];
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

            // Offset can't be less zero
            // Limit must be between 1 and 500
            if ($value < 0 || ($value > 500 || $value === 0) && $field === 'limit') {
                $message = sprintf('Invalid navigation field "%s" value: "%s"', $field, $nav[$field]);
                throw new Exceptions\InvalidArgumentException($message);
            }

            $result[$names_match[$field]] = $value;
        }

        return $result;
    }
}
