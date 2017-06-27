<?php

namespace amoCRM;

use amoCRM\Interfaces\Requester;
use PHPUnit\Framework\TestCase;

class RequesterFabricTest extends TestCase
{
    public function testReturnRequester()
    {
        $this->assertInstanceOf(
            Requester::class,
            RequesterFabric::make('test', 'some@example.com', md5('string'))
        );
    }
}
