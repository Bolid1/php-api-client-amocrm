<?php

namespace amoCRM\Service\Factory;

use amoCRM\Entity;
use amoCRM\Service\APIRequesterService;
use amoCRM\Service\Interfaces;
use amoCRM\Service\PromoRequesterService;
use amoCRM\Service\UnsortedRequesterService;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\RequestOptions;

/**
 * Class RequesterFactory
 * @package amoCRM
 */
final class RequesterServicesFactory
{
    /**
     * @param string $subdomain
     * @param string $login
     * @param string $api_key
     * @return Interfaces\RequesterService
     * @throws \amoCRM\Exception\InvalidArgumentException
     */
    public static function makeAPI($subdomain, $login, $api_key)
    {
        list($account, $user, $curl) = self::buildConstructorArgs($subdomain, $login, $api_key);

        return new APIRequesterService($account, $user, $curl);
    }

    /**
     * @param string $subdomain
     * @param string $login
     * @param string $api_key
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
     * @return Interfaces\UnsortedRequesterService
     * @throws \amoCRM\Exception\InvalidArgumentException
     */
    public static function makeUnsorted($subdomain, $login, $api_key)
    {
        list($account, $user, $curl) = self::buildConstructorArgs($subdomain, $login, $api_key);

        return new UnsortedRequesterService($account, $user, $curl);
    }

    /**
     * @return \amoCRM\Service\Interfaces\PromoRequesterService
     */
    public static function makePromo()
    {
        return new PromoRequesterService(self::buildClient());
    }
}
