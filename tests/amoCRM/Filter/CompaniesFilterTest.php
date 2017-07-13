<?php

namespace Tests\amoCRM\Filter;

use amoCRM\Filter\BaseEntityFilter;
use amoCRM\Filter\CompaniesFilter;
use amoCRM\Filter\Interfaces\SearchFilter;
use PHPUnit\Framework\TestCase;

/**
 * Class CompaniesFilterTest
 * @package Tests\amoCRM\Filter
 */
class CompaniesFilterTest extends TestCase
{
    /**
     * @coversNothing
     */
    public function testInstanceOf()
    {
        $filter = new CompaniesFilter();

        $this->assertInstanceOf(
            SearchFilter::class,
            $filter
        );

        $this->assertInstanceOf(
            BaseEntityFilter::class,
            $filter
        );
    }
}
