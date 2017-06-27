<?php

namespace HTTP\Interfaces;

use HTTP\Exceptions;


/**
 * Class CurlResult
 * @package Libs\Helpers\Http
 * Class for hold curl result
 */
interface CurlResult
{
    /**
     * Get info for result.
     * If key specified, return just info by key
     *
     * @param string [$key = NULL]
     * @return array|mixed|NULL
     */
    public function getInfo($key = null);

    /**
     * Return raw body of result
     * @return string
     */
    public function getBody();

    /**
     * Return json decoded body
     * @param string [$key = NULL]
     * @return mixed|null
     * @throws Exceptions\InvalidArgumentException
     */
    public function getBodyFromJSON($key = null);
}
