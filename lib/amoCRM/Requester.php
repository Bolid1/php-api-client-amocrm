<?php

namespace amoCRM;

use GuzzleHttp\ClientInterface;

/**
 * Class Requester
 * Класс для отправки запросов в amoCRM.
 * Автоматически авторизуется перед первым запросом за сессию.
 * @package amoCRM
 */
final class Requester extends BaseRequester
{
    /** @var Entity\Interfaces\User */
    private $user;
    /** @var boolean */
    private $auth;

    public function __construct(Entity\Interfaces\Account $account, Entity\Interfaces\User $user, ClientInterface $curl)
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
     * @throws \amoCRM\Exception\AuthFailed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \amoCRM\Exception\RuntimeException
     */
    public function get($path, $query = null)
    {
        $this->checkHasAuth();

        return parent::get($path, $query);
    }

    /**
     * If auth not initialized, initialize it
     * @throws Exception\RuntimeException if auth failed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \amoCRM\Exception\AuthFailed
     */
    private function checkHasAuth()
    {
        if ($this->auth !== null) {
            return;
        }

        $this->auth = true;
        $query = ['type' => 'json'] + $this->user->getCredentialsAsArray();
        $this->get('/private/api/auth.php', $query);
    }

    /**
     * Make POST request to account
     *
     * @param string $path
     * @param array|string $data
     * @param array|string [$query=null]
     *
     * @return array
     * @throws \amoCRM\Exception\AuthFailed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \amoCRM\Exception\RuntimeException
     */
    public function post($path, $data, $query = null)
    {
        $this->checkHasAuth();

        return parent::post($path, $data, $query);
    }
}
