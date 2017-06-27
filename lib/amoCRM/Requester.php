<?php

namespace amoCRM;

use HTTP\Interfaces\Curl;
use HTTP\Interfaces\CurlResult;

/**
 * Class Requester
 * @package amoCRM
 * Класс для отправки запросов в amoCRM.
 * Автоматически авторизуется перед первым запросом за сессию.
 */
final class Requester implements Interfaces\Requester
{
    /** @var Interfaces\Account */
    private $_account;

    /** @var Interfaces\User */
    private $_user;

    /** @var Curl */
    private $_curl;

    /** @var string */
    private $_cookie_file = null;

    /**
     * Requester constructor.
     * @param Interfaces\Account $account
     * @param Interfaces\User $user
     * @param Curl $curl
     */
    public function __construct(Interfaces\Account $account, Interfaces\User $user, Curl $curl)
    {
        $this->_account = $account;
        $this->_user = $user;
        $this->_curl = $curl;
    }

    /**
     * При дестрое класса необходимо почистить за собой хранилище печенек
     */
    function __destruct()
    {
        $this->destroy_cookie();
    }

    /**
     * Destroy cookie file
     */
    private function destroy_cookie()
    {
        if (!empty($this->_cookie_file)) {
            if (file_exists($this->_cookie_file)) {
                unlink($this->_cookie_file);
            }
        }

        unset($this->_cookie_file);
    }

    /**
     * Make GET request to account
     *
     * @param string $path
     * @param array|string [$query=null]
     *
     * @return array
     */
    public function get($path, $query = null)
    {
        $this->ensureCurlInitialized();
        $curl_result = $this->_curl->get($this->buildPath($path), $query);

        return $this->extractResponse($curl_result);
    }

    /**
     * If cookie not initialized, initialize it
     * @throws Exceptions\RuntimeException if auth failed
     */
    private function ensureCurlInitialized()
    {
        if (!empty($this->_cookie_file)) {
            return;
        }

        $this->_cookie_file = $this->buildCookiePath();
        $this->_curl->setCookie($this->_cookie_file);

        $query = ['type' => 'json'] + $this->_user->getCredentialsAsArray();
        $auth_result = $this->get('/private/api/auth.php', $query);

        if (empty($auth_result['auth'])) {
            throw new Exceptions\RuntimeException('Auth failed');
        }
    }

    /**
     * Build cookie path
     *
     * @return string
     */
    private function buildCookiePath()
    {
        $md5 = md5($this->_user->getCredentials() . $this->_account->getAddress());
        $base_path = defined('TMP_DIR') ? TMP_DIR : __DIR__ . '/';

        return $base_path . $md5 . '_' . time() . '.cookie';
    }

    /**
     * Build full request url
     * @param string $path
     * @return string
     */
    private function buildPath($path)
    {
        return sprintf('%s/%s', $this->_account->getAddress(), ltrim($path, '/'));
    }

    /**
     * Prepare API response
     *
     * @param CurlResult $curl_result
     * @return array
     */
    private function extractResponse(CurlResult $curl_result)
    {
        $http_code = $curl_result->getInfo('http_code');

        if (in_array($http_code, [401, 403], true)) {
            $this->destroy_cookie();
        }

        $result = $http_code === 204 ? [] : $curl_result->getBodyFromJSON();

        return isset($result['response']) ? $result['response'] : $result;
    }

    /**
     * Make POST request to account
     *
     * @param string $path
     * @param array|string $data
     * @param array|string [$query=null]
     *
     * @return array
     */
    public function post($path, $data, $query = null)
    {
        $this->ensureCurlInitialized();
        $curl_result = $this->_curl->post($this->buildPath($path), $data, $query);

        return $this->extractResponse($curl_result);
    }
}
