<?php

namespace Tests\amoCRM\Unsorted;

use amoCRM\Interfaces\Requester;
use amoCRM\Unsorted\BaseUnsortedRequester;
use amoCRM\Unsorted\UnsortedFormRequester;
use PHPUnit\Framework\TestCase;

/**
 * Class UnsortedFormRequesterTest
 * @package Tests\amoCRM\Unsorted
 * @covers \amoCRM\Unsorted\UnsortedFormRequester
 */
final class UnsortedFormRequesterTest extends TestCase
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
