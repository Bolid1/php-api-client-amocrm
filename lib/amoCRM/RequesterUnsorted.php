<?php

namespace amoCRM;

use GuzzleHttp\ClientInterface;

/**
 * Class Requester
 * Класс для отправки запросов в amoCRM.
 * Нет авторизации, но к каждому запросу
 * примешивается логин и ключ пользователя
 * @package amoCRM
 */
final class RequesterUnsorted extends BaseRequester
{
    /** @var Interfaces\User */
    private $_user;

    public function __construct(Interfaces\Account $account, Interfaces\User $user, ClientInterface $curl)
    {
        $this->_user = $user;
        parent::__construct($account, $curl);
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
        return parent::get($path, $this->addCredentials($query));
    }

    /**
     * @param null|string|array $query
     * @return string|array $query
     */
    private function addCredentials($query)
    {
        if (is_null($query)) {
            $query = [];
        }

        if (is_array($query)) {
            $query += $this->_user->getCredentialsAsArray(Interfaces\User::CREDENTIALS_TYPE_UNSORTED);
        } elseif (is_string($query) && strlen($query) === 0) {
            $query = $this->_user->getCredentials(Interfaces\User::CREDENTIALS_TYPE_UNSORTED);
        } else {
            $query = rtrim($query,
                    '&') . '&' . $this->_user->getCredentials(Interfaces\User::CREDENTIALS_TYPE_UNSORTED);
        }

        return $query;
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
        return parent::post($path, $data, $this->addCredentials($query));
    }
}
