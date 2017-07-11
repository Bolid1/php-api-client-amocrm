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
    private $user;

    public function __construct(Interfaces\Account $account, Interfaces\User $user, ClientInterface $curl)
    {
        $this->user = $user;
        parent::__construct($account, $curl);
    }

    /**
     * Make GET request to account
     *
     * @param string $path
     * @param array|string [$query=null]
     *
     * @return array
     * @throws \amoCRM\Exceptions\AuthFailed
     * @throws \GuzzleHttp\Exception\GuzzleException
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
        if ($query === null) {
            $query = [];
        }

        if (is_array($query)) {
            $credentials = $this->user->getCredentialsAsArray(Interfaces\User::CREDENTIALS_TYPE_UNSORTED);
            $query = array_merge($query, $credentials);
        } elseif (is_string($query) && $query === '') {
            $query = $this->user->getCredentials(Interfaces\User::CREDENTIALS_TYPE_UNSORTED);
        } else {
            $credentials = $this->user->getCredentials(Interfaces\User::CREDENTIALS_TYPE_UNSORTED);
            $query = rtrim($query, '&') . '&' . $credentials;
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
     * @throws \amoCRM\Exceptions\AuthFailed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post($path, $data, $query = null)
    {
        return parent::post($path, $data, $this->addCredentials($query));
    }
}
