<?php

namespace amoCRM\Unsorted;

use amoCRM\Exceptions;
use amoCRM\Interfaces\Requester;

/**
 * Class BaseUnsortedRequester
 * Common methods for unsorted requests
 * @package amoCRM\Unsorted
 */
abstract class BaseUnsortedRequester implements Interfaces\BaseUnsortedRequester
{
    const BASE_PATH = 'api/unsorted/';

    /** @var Requester */
    private $_requester;

    /** @var string */
    private $_category;

    /**
     * BaseUnsortedRequester constructor.
     * @param Requester $requester
     * @param string $category
     */
    public function __construct(Requester $requester, $category)
    {
        $this->_requester = $requester;
        $this->setCategory($category);
    }

    /**
     * @param string $category
     */
    private function setCategory($category)
    {
        $this->_category = $category;
    }

    /**
     * Send request to add unsorted
     * @link https://developers.amocrm.ru/rest_api/unsorted/add.php
     *
     * @param array $elements
     * @return bool
     * @throws Exceptions\InvalidResponseException
     */
    public function add(array $elements)
    {
        $elements = $this->ensureIsArrayOfElements($elements);

        $data = [
            'request' => [
                'unsorted' => [
                    'category' => $this->_category,
                    'add' => $elements,
                ],
            ],
        ];

        /**
         * На данный момент $response выглядит так:
         * 'response' => [
         *   'unsorted' => [
         *     'add' => [
         *       'status' => 'success',
         *     ],
         *   ],
         * ],
         */
        $response = $this->_requester->post(self::BASE_PATH . 'add/', $data);

        if (!isset($response['unsorted']['add']['status'])) {
            throw new Exceptions\InvalidResponseException(json_encode($response));
        }

        return $response['unsorted']['add']['status'] === 'success';
    }

    /**
     * Check for possible wrong nesting level
     *
     * @param array $elements
     * @return array
     * @throws Exceptions\InvalidArgumentException
     */
    private function ensureIsArrayOfElements(array $elements)
    {
        $result = [];

        foreach ($elements as $element) {
            if (!is_array($element) && !($element instanceof BaseUnsorted)) {
                $message = sprintf('Element "%s" is not an array and not unsorted', var_export($element, true));
                throw new Exceptions\InvalidArgumentException($message);
            }

            if ($element instanceof BaseUnsorted) {
                $result[] = $element->toAmo();
            } else {
                $result[] = $element;
            }
        }

        return $result;
    }
}
