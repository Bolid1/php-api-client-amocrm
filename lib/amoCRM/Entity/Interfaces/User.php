<?php

namespace amoCRM\Entity\Interfaces;

/**
 * Class User
 * @package amoCRM
 * Keep user info for auth
 */
interface User
{
    const CREDENTIALS_TYPE_API = 'api';
    const CREDENTIALS_TYPE_UNSORTED = 'unsorted';

    /**
     * Generate credential string for auth in amoCRM API
     *
     * @param string $type
     * @return string
     */
    public function getCredentials($type = self::CREDENTIALS_TYPE_API);

    /**
     * Generate credential string for auth in amoCRM API
     *
     * @param string $type
     * @return array
     */
    public function getCredentialsAsArray($type = self::CREDENTIALS_TYPE_API);
}
