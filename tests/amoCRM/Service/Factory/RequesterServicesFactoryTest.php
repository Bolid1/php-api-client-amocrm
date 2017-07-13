<?php

namespace Tests\amoCRM\Factory;

use amoCRM\Exception\AuthFailed;
use amoCRM\Service\APIRequesterService;
use amoCRM\Service\Factory\RequesterServicesFactory;
use amoCRM\Service\PromoRequesterService;
use amoCRM\Service\UnsortedRequesterService;
use PHPUnit\Framework\TestCase;

/**
 * Class RequesterFactoryTest
 * @package amoCRM
 * @covers \amoCRM\Service\Factory\RequesterServicesFactory
 */
final class RequesterServicesFactoryTest extends TestCase
{
    public function testReturnRequester()
    {
        $requester = RequesterServicesFactory::makeAPI('test', 'some@example.com', md5('string'));

        $this->assertInstanceOf(
            APIRequesterService::class,
            $requester
        );

        // Check if request doing normally
        // Check cURL verify turned off
        // Check http errors throwing disabled
        $this->expectException(AuthFailed::class);
        $requester->get('/private/api/auth.php', ['type' => 'json']);
    }

    public function testReturnRequesterUnsorted()
    {
        $requester = RequesterServicesFactory::makeUnsorted('test', 'some@example.com', md5('string'));

        $this->assertInstanceOf(
            UnsortedRequesterService::class,
            $requester
        );

        // Check if request doing normally
        // Check cURL verify turned off
        // Check http errors throwing disabled
        $this->expectException(AuthFailed::class);
        $requester->get('/private/api/auth.php', ['type' => 'json']);
    }

    public function testReturnRequesterPromo()
    {
        $requester = RequesterServicesFactory::makePromo();

        $this->assertInstanceOf(
            PromoRequesterService::class,
            $requester
        );

        // Check if request doing normally
        // Check cURL verify turned off
        // Check http errors throwing disabled
        $response = $requester->domains('dev');
        $expected = [
            [
                'status' => 'active',
                'subdomain' => 'dev',
                'base_domain' => 'amocrm.ru',
                'account_domain' => 'dev.amocrm.ru',
                'account_type' => 'ru',
                'top_domain' => 'ru',
            ],
        ];
        $this->assertEquals($expected, $response);
    }
}
