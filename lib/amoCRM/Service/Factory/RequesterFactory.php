<?php

namespace amoCRM\Service\Factory;

use amoCRM\Entity;
use amoCRM\Service\Interfaces;
use amoCRM\Service\Requester;
use amoCRM\Service\RequesterPromo;
use amoCRM\Service\RequesterUnsorted;
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
     * @throws \amoCRM\Exception\InvalidArgumentException
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
     * @throws \amoCRM\Exception\InvalidArgumentException
     */
    private static function buildConstructorArgs($subdomain, $login, $api_key)
    {
        $account = new Entity\Account($subdomain);
        $user = new Entity\User($login, $api_key);
        $curl = self::buildClient();

        return [$account, $user, $curl];
    }

    /**
     * @return Client
     */
    private static function buildClient()
    {
        return new Client([
            RequestOptions::COOKIES => new CookieJar,
            RequestOptions::HEADERS => [
                'User-Agent' => 'amoCRM-PHP-API-client/0.5.0',
            ],
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::VERIFY => false,
        ]);
    }

    /**
     * @param string $subdomain
     * @param string $login
     * @param string $api_key
     * @return RequesterUnsorted
     * @throws \amoCRM\Exception\InvalidArgumentException
     */
    public static function makeUnsorted($subdomain, $login, $api_key)
    {
        list($account, $user, $curl) = self::buildConstructorArgs($subdomain, $login, $api_key);

        return new RequesterUnsorted($account, $user, $curl);
    }

    /**
     * @return \amoCRM\Service\Interfaces\RequesterPromo
     */
    public static function makePromo()
    {
        return new RequesterPromo(self::buildClient());
    }
}
