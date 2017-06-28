<?php

namespace amoCRM\Unsorted\Interfaces;

/**
 * Interface BaseUnsortedRequester
 * Common methods for unsorted requests
 * @package amoCRM\Unsorted\Interfaces
 */
interface BaseUnsortedRequester
{
    /**
     * Send request to add unsorted
     * @link https://developers.amocrm.ru/rest_api/unsorted/add.php
     *
     * @param array $elements
     * @return bool
     * @throws \amoCRM\Exceptions\InvalidResponseException
     */
    public function add(array $elements);
}
