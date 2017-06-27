<?php

namespace HTTP\Interfaces;

use HTTP\CurlResult;


/**
 * Class Curl
 * @package Libs\Helpers\Http
 * Class for execute curl
 */
interface Curl
{
    /**
     * Устанавливаем значение в заголовки запроса.
     * Если передать пустое значение, то заголовок будет удалён.
     *
     * @param string $header
     * @param string $value
     * @return \HTTP\Curl
     */
    public function setHeader($header, $value);

    /**
     * Массовое добавление заголовков
     *
     * @param array $headers
     * @return \HTTP\Curl
     */
    public function addHeaders(array $headers);

    /**
     * Отправка GET запроса
     *
     * @param string $url
     * @param array|string [$query_string = null]
     *
     * @return CurlResult
     */
    public function get($url, $query_string = null);

    /**
     * Отправка POST запроса
     *
     * @param string $url
     * @param array|string [$post_fields = null]
     * @param array|string [$query_string = null]
     * @param boolean [$build_post = true]
     *
     * @return CurlResult
     */
    public function post($url, $post_fields = null, $query_string = null, $build_post = true);

    /**
     * Скачивание файла
     *
     * @param string $url - откуда качать
     * @param string $path - куда качать
     *
     * @return CurlResult
     */
    public function download($url, $path);

    /**
     * Устанавливаем печеньки
     *
     * @param string [$file=null] - путь к файлу, где их хранить
     * @param string [$raw_string=null] - начальное содержимое печенек
     *
     * @return \HTTP\Curl
     */
    public function setCookie($file = null, $raw_string = null);
}
