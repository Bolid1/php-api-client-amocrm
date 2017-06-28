<?php

namespace Tests\amoCRM\Unsorted;

use PHPUnit\Framework\TestCase;
use amoCRM\Interfaces\Requester;
use amoCRM\Unsorted\BaseUnsortedRequester;
use amoCRM\Unsorted\UnsortedFormRequester;

class UnsortedFormRequesterTest extends TestCase
{

    public function testInstanceOfBaseUnsortedRequester()
    {
        /** @var Requester $requester */
        $requester = $this->createMock(Requester::class);

        $this->assertInstanceOf(
            BaseUnsortedRequester::class,
            new UnsortedFormRequester($requester)
        );
    }
}
