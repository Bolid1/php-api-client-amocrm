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
        $account = new Account($subdomain);
        $user = new User($login, $api_key);
        $curl = new Client([
            RequestOptions::COOKIES => new CookieJar,
            RequestOptions::HEADERS => [
                'User-Agent' => 'amoCRM-PHP-API-client/0.5.0',
            ],
        ]);

        return new Requester($account, $user, $curl);
    }

    /**
     * @param string $subdomain
     * @param string $login
     * @param string $api_key
     * @return RequesterUnsorted
     */
    public static function makeUnsorted($subdomain, $login, $api_key)
    {
        $account = new Account($subdomain);
        $user = new User($login, $api_key);
        $curl = new Client([
            RequestOptions::COOKIES => new CookieJar,
            RequestOptions::HEADERS => [
                'User-Agent' => 'amoCRM-PHP-API-client/0.5.0',
            ],
        ]);

        return new RequesterUnsorted($account, $user, $curl);
    }
}
