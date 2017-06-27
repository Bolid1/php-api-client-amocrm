<?php

namespace HTTP;

/**
 * Class CurlResult
 * @package Libs\Helpers\Http
 * Class for hold curl result
 */
final class CurlResult implements Interfaces\CurlResult
{
    /** @var array */
    private $_body = [
        'array' => null,
        'raw' => '',
    ];

    /** @var array */
    private $_curl_info = [];

    /**
     * CurlResult constructor.
     * @param string $result
     * @param array $info
     */
    public function __construct($result, $info)
    {
        $this->_body['raw'] = $result;
        $this->_curl_info = $info;
    }

    /**
     * Return json decoded body
     * @param string [$key = NULL]
     * @return mixed|null
     * @throws Exceptions\InvalidArgumentException
     */
    public function getBodyFromJSON($key = null)
    {
        if (is_null($this->_body['array'])) {
            $this->_body['array'] = $this->decodeBody();
        }

        $result = $this->_body['array'];

        if (isset($key)) {
            $result = isset($result[$key]) ? $result[$key] : null;
        }

        return $result;
    }

    /**
     * @return array
     * @throws Exceptions\InvalidArgumentException
     */
    private function decodeBody()
    {
        $body = $this->getBody();

        if (strlen($body) === 0) {
            return [];
        }

        $result = json_decode($body, true);
        if (!is_array($result)) {
            $message = 'Result from url "%s" body is not json, code "%d", raw result: "%s"';
            $message = sprintf($message, $this->getInfo('url'), $this->getInfo('http_code'), $body);
            throw new Exceptions\InvalidArgumentException($message, 500);
        }

        return $result;
    }

    /**
     * Return raw body of result
     * @return string
     */
    public function getBody()
    {
        return (string)$this->_body['raw'];
    }

    /**
     * Get info for result.
     * If key specified, return just info by key
     *
     * @param string [$key = NULL]
     * @return array|mixed|NULL
     */
    public function getInfo($key = null)
    {
        $result = $this->_curl_info;

        if (isset($key)) {
            $result = isset($result[$key]) ? $result[$key] : null;
        }

        return $result;
    }
}
