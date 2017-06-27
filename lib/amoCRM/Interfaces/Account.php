<?php

namespace amoCRM\Interfaces;


/**
 * Class Account
 * @package amoCRM
 * Keep account info for auth
 */
interface Account
{
    /**
     * @param string $top_level_domain
     */
    public function setTopLevelDomain($top_level_domain);

    /**
     * Generates base url for account
     *
     * @return string
     */
    public function getAddress();
}
