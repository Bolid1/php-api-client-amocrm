<?php

namespace amoCRM;

/**
 * Class User
 * @package amoCRM
 * Keep user info for auth
 */
final class User implements Interfaces\User
{
    /**
     * User login
     * @var string
     */
    private $_login;

    /**
     * User API hash
     * @var string
     */
    private $_api_key;

    /**
     * User constructor
     *
     * @param string $login
     * @param string $api_key
     * @throws Exceptions\InvalidArgumentException
     */
    public function __construct($login, $api_key)
    {
        $this->ensureIsValidEmail($login);
        $this->ensureIsValidHash($api_key);

        $this->_login = $login;
        $this->_api_key = $api_key;
    }

    /**
     * Check if email is valid
     *
     * @param string $email
     * @throws Exceptions\InvalidArgumentException
     */
    private function ensureIsValidEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = sprintf('"%s" is not a valid email address', $email);
            throw new Exceptions\InvalidArgumentException($message);
        }
    }

    /**
     * Check if api key is valid
     *
     * @param string $hash
     * @throws Exceptions\InvalidArgumentException
     */
    private function ensureIsValidHash($hash)
    {
        if (!preg_match('/^[a-z0-9]{32}$/', $hash)) {
            $message = sprintf('"%s" is not a valid api key', $hash);
            throw new Exceptions\InvalidArgumentException($message);
        }
    }

    /**
     * Generate credential string for auth in amoCRM API
     *
     * @return string
     */
    public function getCredentials()
    {
        return http_build_query($this->getCredentialsAsArray());
    }

    /**
     * Generate credential string for auth in amoCRM API
     *
     * @return array
     */
    public function getCredentialsAsArray()
    {
        return [
            'USER_LOGIN' => $this->_login,
            'USER_HASH' => $this->_api_key,
        ];
    }
}
