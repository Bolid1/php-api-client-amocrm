<?php

namespace amoCRM\Interfaces;


/**
 * Class User
 * @package amoCRM
 * Keep user info for auth
 */
interface User
{
    /**
     * Generate credential string for auth in amoCRM API
     *
     * @return string
     */
    public function getCredentials();

    /**
     * Generate credentials array for auth in amoCRM API
     * @return array
     */
    public function getCredentialsAsArray();
}
