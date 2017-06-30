<?php

namespace amoCRM;

use amoCRM\Interfaces\Requester;
use PHPUnit\Framework\TestCase;

class RequesterFactoryTest extends TestCase
{
    public function testReturnRequester()
    {
        $requester = RequesterFactory::make('test', 'some@example.com', md5('string'));

        $this->assertInstanceOf(
            Requester::class,
            $requester
        );

        // Check if request doing normally
        // Check cURL verify turned off
        // Check http errors throwing disabled
        $this->expectException('\amoCRM\Exceptions\AuthFailed');
        $requester->get('/private/api/auth.php', ['type' => 'json']);
    }

    public function testReturnRequesterUnsorted()
    {
        $requester = RequesterFactory::makeUnsorted('test', 'some@example.com', md5('string'));

        $this->assertInstanceOf(
            RequesterUnsorted::class,
            $requester
        );

        // Check if request doing normally
        // Check cURL verify turned off
        // Check http errors throwing disabled
        $this->expectException('\amoCRM\Exceptions\AuthFailed');
        $requester->get('/private/api/auth.php', ['type' => 'json']);
    }

    public function testReturnRequesterPromo()
    {
        $requester = RequesterFactory::makePromo();

        $this->assertInstanceOf(
            RequesterPromo::class,
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
