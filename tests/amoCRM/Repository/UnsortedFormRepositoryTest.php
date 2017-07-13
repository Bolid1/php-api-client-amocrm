<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\UnsortedForm;
use amoCRM\Repository\BaseUnsortedRepository;
use amoCRM\Repository\UnsortedFormRepository;
use amoCRM\Service\Interfaces\UnsortedRequesterService;
use PHPUnit\Framework\TestCase;

/**
 * Class UnsortedFormRequesterTest
 * @package Tests\amoCRM\Entity
 */
final class UnsortedFormRepositoryTest extends TestCase
{
    /**
     * @coversNothing
     */
    public function testInstanceOfBaseUnsortedRequester()
    {
        $requester = $this->createMock(UnsortedRequesterService::class);

        $this->assertInstanceOf(
            BaseUnsortedRepository::class,
            new UnsortedFormRepository($requester)
        );
    }

    /**
     * @covers \amoCRM\Repository\UnsortedFormRepository::__construct
     */
    public function testIsFormCategory()
    {
        $requester = $this->createMock(UnsortedRequesterService::class);
        $repository = new UnsortedFormRepository($requester);

        $this->assertEquals(UnsortedForm::CATEGORY, $repository->getCategory());
    }
}
