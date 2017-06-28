<?php

namespace amoCRM;

use amoCRM\Interfaces\Requester;
use PHPUnit\Framework\TestCase;

class RequesterFactoryTest extends TestCase
{
    public function testReturnRequester()
    {
        $this->assertInstanceOf(
            Requester::class,
            RequesterFactory::make('test', 'some@example.com', md5('string'))
        );
    }
}
