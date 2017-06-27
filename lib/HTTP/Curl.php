<?php

namespace HTTP;

/**
 * Class Curl
 * @package Libs\Helpers\Http
 * Class for execute curl
 */
final class Curl implements Interfaces\Curl
{
    /** @var resource */
    private $_ch;

    /** @var array */
    private $_headers = [];

    /** @var string */
    private $_cookie = '';

    /** @var string */
    private $_cookie_file = '';

    /**
     * Curl constructor.
     *
     * @param string $user_agent - your custom user agent
     */
    public function __construct($user_agent = 'amoCRM-PHP-API-client/0.5.0')
    {
        $this->_ch = curl_init();
        $this->init();
        $this->setHeader('User-Agent', $user_agent);
    }

    /**
     * Инициализация ресурса cURL
     *
     * @return $this
     */
    private function init()
    {
        $this->curlReset();

        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_HTTPHEADER => $this->getHeaders(),
            CURLOPT_COOKIESESSION => false,
        ];
        $this->setOptions($options)->setCookie($this->_cookie_file, $this->_cookie);

        return $this;
    }

    /**
     * Сбрасываем параметры cURL до дефолтных
     */
    private function curlReset()
    {
        if (function_exists('curl_reset')) {
            curl_reset($this->_ch);
        } else {
            curl_close($this->_ch);
            $this->_ch = curl_init();
        }
    }

    /**
     * Формирования массива заголовков для запроса
     *
     * @return array
     */
    private function getHeaders()
    {
        $headers = [];

        foreach ($this->_headers as $header => $value) {
            $headers[] = "{$header}: {$value}";
        }

        return $headers;
    }

    /**
     * Устанавливаем печеньки
     *
     * @param string [$file=null] - путь к файлу, где их хранить
     * @param string [$raw_string=null] - начальное содержимое печенек
     *
     * @return $this
     */
    public function setCookie($file = null, $raw_string = null)
    {
        if (!$file && !$raw_string) {
            $file = $raw_string = '';
        } else {
            if (!($file && is_string($file))) {
                $file = '';
            }
            if (!($raw_string && is_string($raw_string))) {
                $raw_string = '';
            }
        }


        $this->_cookie = $raw_string;
        $this->_cookie_file = $file;

        $options = [CURLOPT_COOKIE => $this->_cookie];
        if ($this->_cookie_file) {
            $options += [
                CURLOPT_COOKIEFILE => $this->_cookie_file,
                CURLOPT_COOKIEJAR => $this->_cookie_file,
            ];
            touch($this->_cookie_file);
        }
        $this->setOptions($options);

        return $this;
    }

    /**
     * Метод для проставления параметров cURL
     *
     * @param array $options
     *
     * @return $this
     */
    private function setOptions(array $options)
    {
        curl_setopt_array($this->_ch, $options);

        return $this;
    }

    /**
     * Устанавливаем значение в заголовки запроса.
     * Если передать пустое значение, то заголовок будет удалён.
     *
     * @param string $header
     * @param string $value
     *
     * @return $this
     */
    public function setHeader($header, $value)
    {
        if (!($header && is_string($header))) {
            throw new \InvalidArgumentException('Invalid header type, string expected');
        }

        if ($header === 'User-Agent') {
            $this->setUserAgent($value);

            return $this;
        }

        if (!$value) {
            unset($this->_headers[$header]);
        } elseif (!is_string($value)) {
            throw new \InvalidArgumentException('Invalid header type, string or NULL expected');
        } else {
            $this->_headers[$header] = $value;
        }

        return $this;
    }

    /**
     * @param string $value
     */
    private function setUserAgent($value)
    {
        $this->_headers['User-Agent'] = 'amoCRM-PHP-API-client/0.5.0/' . $value;
    }

    /**
     * Выключаем инициализированный ресурс
     */
    public function __destruct()
    {
        if ($this->_ch) {
            curl_close($this->_ch);
        }
    }

    /**
     * Массовое добавление заголовков
     *
     * @param array $headers
     *
     * @return $this
     */
    public function addHeaders(array $headers)
    {
        foreach ($headers as $header => $value) {
            $this->setHeader($header, $value);
        }

        return $this;
    }

    /**
     * Отправка GET запроса
     *
     * @param string $url
     * @param array|string [$query_string = null]
     *
     * @return CurlResult
     */
    public function get($url, $query_string = null)
    {
        return $this->request('get', $url, $query_string);
    }

    /**
     * Отправка запроса по параметрам
     *
     * @param string $type - тип запроса (get || post)
     * @param string $url
     * @param array|string $query_string
     * @param array|string [$post_data = null]
     * @param bool [$build_post = true]
     *
     * @return CurlResult
     * @throws \Exception
     */
    private function request($type, $url, $query_string, $post_data = null, $build_post = true)
    {
        $this->checkNeedSleep($url);
        $options = [CURLOPT_URL => ltrim($url, '?')];

        if ($query_string) {
            $options[CURLOPT_URL] .= '?' . $this->buildQuery($query_string);
        }

        switch ($type) {
            case 'get':
                $options[CURLOPT_POST] = false;
                break;
            case 'post':
                $options[CURLOPT_POST] = true;
                if ($build_post) {
                    $options[CURLOPT_POSTFIELDS] = $post_data ? $this->buildQuery($post_data) : '';
                } else {
                    $options[CURLOPT_POSTFIELDS] = $post_data;
                }
                break;
        }

        $options[CURLOPT_HTTPHEADER] = $this->getHeaders();
        $this->setOptions($options);

        $raw_result = false;
        $counter = 0;
        while ($raw_result === false || curl_getinfo($this->_ch, CURLINFO_HTTP_CODE) == 504) {
            // Подождём, может отлипнет
            if (++$counter > 1) {
                sleep(5);
            }

            $raw_result = curl_exec($this->_ch);

            if (++$counter > 10) {
                // Если получили в ответе 504, то будем повторять запрос, пока не получим ответ
                break;
            }
        }

        if ($raw_result === false) {
            throw new \Exception('Empty response from url: ' . $url);
        }

        $result = new CurlResult($raw_result, curl_getinfo($this->_ch));

        $this->init();

        return $result;
    }

    /**
     * Защита от блокировки в API
     *
     * @param string $url
     */
    private function checkNeedSleep($url)
    {
        if (strpos($url, '/private/api/v2/') === false) {
            // No need slowdown for NOT API requests
            return;
        }

        $now = microtime(true);
        static $last_check = null;
        if (!isset($last_check)) {
            $last_check = $now;

            return;
        }

        // Если с момента последнего запроса прошло меньше 1 секунды
        $sleep_time = 1;
        $time_from_last_request = $now - $last_check;
        if ($time_from_last_request < $sleep_time) {
            // Чутка притормозим
            usleep(($sleep_time - $time_from_last_request) * 1000000);
        }

        $last_check = $now;
    }

    /**
     * Проверяем, что информация в виде http строки
     *
     * @param array|string $data
     *
     * @return string
     */
    private function buildQuery($data)
    {
        if (is_array($data)) {
            $data = http_build_query($data);
        } elseif (!is_string($data)) {
            throw new \InvalidArgumentException('Invalid data type given. Expected array or string', 400);
        }

        return $data;
    }

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
    public function post($url, $post_fields = null, $query_string = null, $build_post = true)
    {
        return $this->request('post', $url, $query_string, $post_fields, $build_post);
    }

    /**
     * Скачивание файла
     *
     * @param string $url - откуда качать
     * @param string $path - куда качать
     *
     * @return CurlResult
     */
    public function download($url, $path)
    {
        $fp = fopen($path, 'w');

        $this->setOptions([CURLOPT_FILE => $fp]);

        $result = $this->request('download', $url, null, null);

        fclose($fp);

        return $result;
    }
}
