<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Repository\BaseUnsortedRepository;
use amoCRM\Repository\UnsortedFormRepository;
use amoCRM\Service\Interfaces\Requester;
use PHPUnit\Framework\TestCase;

/**
 * Class UnsortedFormRequesterTest
 * @package Tests\amoCRM\Entity
 * @covers \amoCRM\Repository\UnsortedFormRepository
 */
final class UnsortedFormRepositoryTest extends TestCase
{

    public function testInstanceOfBaseUnsortedRequester()
    {
        /** @var Requester $requester */
        $requester = $this->createMock(Requester::class);

        $this->assertInstanceOf(
            BaseUnsortedRepository::class,
            new UnsortedFormRepository($requester)
        );
    }
}
