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
}
