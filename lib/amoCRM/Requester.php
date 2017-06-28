<?php

namespace amoCRM;

/**
 * Class Requester
 * Класс для отправки запросов в amoCRM.
 * Автоматически авторизуется перед первым запросом за сессию.
 * @package amoCRM
 */
final class Requester extends BaseRequester
{
    /** @var boolean */
    private $_auth;

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
        $this->checkHasAuth();

        return parent::get($path, $query);
    }

    /**
     * If auth not initialized, initialize it
     * @throws Exceptions\RuntimeException if auth failed
     */
    private function checkHasAuth()
    {
        if (isset($this->_auth)) {
            return;
        }

        $this->_auth = true;
        $query = ['type' => 'json'] + $this->_user->getCredentialsAsArray();
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
     */
    public function post($path, $data, $query = null)
    {
        $this->checkHasAuth();

        return parent::post($path, $data, $query);
    }
}
