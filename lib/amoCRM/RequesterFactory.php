<?php

namespace amoCRM;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\RequestOptions;

/**
 * Class RequesterFactory
 * @package amoCRM
 */
final class RequesterFactory
{
    /**
     * @param string $subdomain
     * @param string $login
     * @param string $api_key
     * @return Interfaces\Requester
     */
    public static function make($subdomain, $login, $api_key)
    {
        list($account, $user, $curl) = self::buildConstructorArgs($subdomain, $login, $api_key);

        return new Requester($account, $user, $curl);
    }

    /**
     * @param $subdomain
     * @param $login
     * @param $api_key
     * @return array
     */
    private static function buildConstructorArgs($subdomain, $login, $api_key)
    {
        $account = new Account($subdomain);
        $user = new User($login, $api_key);
        $curl = new Client([
            RequestOptions::COOKIES => new CookieJar,
            RequestOptions::HEADERS => [
                'User-Agent' => 'amoCRM-PHP-API-client/0.5.0',
            ],
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::VERIFY => false,
        ]);

        return [$account, $user, $curl];
    }

    /**
     * @param string $subdomain
     * @param string $login
     * @param string $api_key
     * @return RequesterUnsorted
     */
    public static function makeUnsorted($subdomain, $login, $api_key)
    {
        list($account, $user, $curl) = self::buildConstructorArgs($subdomain, $login, $api_key);

        return new RequesterUnsorted($account, $user, $curl);
    }
}
