<?php

namespace amoCRM;

/**
 * Class Account
 * @package amoCRM
 * Keep account info for auth
 */
final class Account implements Interfaces\Account
{
    const TOP_LEVEL_DOMAIN_RU = 'ru';
    const TOP_LEVEL_DOMAIN_COM = 'com';

    /**
     * Account subdomain
     * @var string
     */
    private $_subdomain;

    /**
     * Account subdomain
     * @var string
     */
    private $_top_level_domain;

    /**
     * Account constructor.
     * @param string $subdomain
     * @param string [$top_level_domain = 'ru']
     */
    public function __construct($subdomain, $top_level_domain = self::TOP_LEVEL_DOMAIN_RU)
    {
        $this->ensureIsValidSubdomain($subdomain);

        $this->_subdomain = $subdomain;
        $this->setTopLevelDomain($top_level_domain);
    }

    /**
     * Check if subdomain is valid
     *
     * @param string $subdomain
     * @throws Exceptions\InvalidArgumentException
     */
    private function ensureIsValidSubdomain($subdomain)
    {
        if (!preg_match('/^[a-z0-9]{3,}$/', $subdomain)) {
            $message = sprintf('"%s" is not a valid subdomain', $subdomain);
            throw new Exceptions\InvalidArgumentException($message);
        }
    }

    /**
     * @param string $top_level_domain
     */
    public function setTopLevelDomain($top_level_domain)
    {
        $this->ensureIsValidTopLevelDomain($top_level_domain);
        $this->_top_level_domain = $top_level_domain;
    }

    /**
     * Check if top level domain is valid
     *
     * @param string $top_level_domain
     * @throws Exceptions\InvalidArgumentException
     */
    private function ensureIsValidTopLevelDomain($top_level_domain)
    {
        $top_level_domains = [
            self::TOP_LEVEL_DOMAIN_RU,
            self::TOP_LEVEL_DOMAIN_COM,
        ];

        if (!in_array($top_level_domain, $top_level_domains, true)) {
            $message = sprintf('"%s" is not a valid top level domain', $top_level_domain);
            throw new Exceptions\InvalidArgumentException($message);
        }
    }

    /**
     * Generates base url for account
     *
     * @return string
     */
    public function getAddress()
    {
        return sprintf('https://%s.amocrm.%s', $this->_subdomain, $this->_top_level_domain);
    }
}
