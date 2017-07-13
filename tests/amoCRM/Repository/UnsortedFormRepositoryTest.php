<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Repository\BaseUnsortedRepository;
use amoCRM\Repository\UnsortedFormRepository;
use amoCRM\Service\Interfaces\RequesterService;
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
        /** @var RequesterService $requester */
        $requester = $this->createMock(RequesterService::class);

        $this->assertInstanceOf(
            BaseUnsortedRepository::class,
            new UnsortedFormRepository($requester)
        );
    }
}
