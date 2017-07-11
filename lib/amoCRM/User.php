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
    private $login;

    /**
     * User API hash
     * @var string
     */
    private $api_key;

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

        $this->login = $login;
        $this->api_key = $api_key;
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
     * @param string $type
     * @return string
     */
    public function getCredentials($type = self::CREDENTIALS_TYPE_API)
    {
        return http_build_query($this->getCredentialsAsArray($type));
    }

    /**
     * Generate credential string for auth in amoCRM API
     *
     * @param string $type
     * @return array
     */
    public function getCredentialsAsArray($type = self::CREDENTIALS_TYPE_API)
    {
        switch ($type) {
            case self::CREDENTIALS_TYPE_UNSORTED:
                $result = ['login' => $this->login, 'api_key' => $this->api_key];
                break;
            case self::CREDENTIALS_TYPE_API:
            default:
                $result = ['USER_LOGIN' => $this->login, 'USER_HASH' => $this->api_key];
        }

        return $result;
    }
}
