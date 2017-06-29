<?php

namespace amoCRM;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Requester
 * Класс для отправки запросов в amoCRM.
 * @package amoCRM
 */
abstract class BaseRequester implements Interfaces\Requester
{
    /** @var Interfaces\User */
    protected $_user;
    /** @var Interfaces\Account */
    private $_account;
    /** @var ClientInterface */
    private $_curl;

    /**
     * Requester constructor.
     * @param Interfaces\Account $account
     * @param Interfaces\User $user
     * @param ClientInterface $curl
     */
    public function __construct(Interfaces\Account $account, Interfaces\User $user, ClientInterface $curl)
    {
        $this->_account = $account;
        $this->_user = $user;
        $this->_curl = $curl;
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
        $curl_result = $this->_curl->request('get', $this->buildPath($path), [
            RequestOptions::QUERY => $query,
        ]);

        return $this->extractResponse($curl_result);
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
     * @param ResponseInterface $curl_result
     * @return array
     * @throws Exceptions\AuthFailed
     */
    private function extractResponse(ResponseInterface $curl_result)
    {
        $http_code = $curl_result->getStatusCode();

        if (in_array($http_code, [401, 403], true)) {
            throw new Exceptions\AuthFailed('Auth failed', $http_code);
        }

        $result = $http_code === 204 ? [] : json_decode((string)$curl_result->getBody(), true);

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
        $curl_result = $this->_curl->request('post', $this->buildPath($path), [
            RequestOptions::QUERY => $query,
            RequestOptions::FORM_PARAMS => $data,
        ]);

        return $this->extractResponse($curl_result);
    }
}