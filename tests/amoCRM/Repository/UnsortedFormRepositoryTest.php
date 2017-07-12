<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Repository\BaseUnsortedRepository;
use amoCRM\Repository\UnsortedFormRequester;
use amoCRM\Service\Interfaces\Requester;
use PHPUnit\Framework\TestCase;

/**
 * Class UnsortedFormRequesterTest
 * @package Tests\amoCRM\Entity
 * @covers \amoCRM\Repository\UnsortedFormRequester
 */
final class UnsortedFormRepositoryTest extends TestCase
{

    public function testInstanceOfBaseUnsortedRequester()
    {
        /** @var Requester $requester */
        $requester = $this->createMock(Requester::class);

        $this->assertInstanceOf(
            BaseUnsortedRepository::class,
            new UnsortedFormRequester($requester)
        );
    }
}
