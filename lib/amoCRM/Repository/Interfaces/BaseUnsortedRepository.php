<?php

namespace amoCRM\Repository\Interfaces;

/**
 * Interface BaseUnsortedRepository
 * Common methods for unsorted requests
 * @package amoCRM\Unsorted\Interfaces
 */
interface BaseUnsortedRepository
{
    /**
     * Send request to add unsorted
     * @link https://developers.amocrm.ru/rest_api/unsorted/add.php
     *
     * @param array $elements
     * @return bool
     * @throws \amoCRM\Exception\InvalidResponseException
     */
    public function add(array $elements);
}
