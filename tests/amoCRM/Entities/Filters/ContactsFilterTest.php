<?php

namespace Tests\amoCRM\Entities\Filters;

use amoCRM\Entities\Filters\BaseEntityFilter;
use amoCRM\Entities\Filters\ContactsFilter;
use amoCRM\Entities\Filters\Interfaces\SearchFilter;
use PHPUnit\Framework\TestCase;

/**
 * Class ContactsFilterTest
 * @package Tests\amoCRM\Entities\Filters
 * @covers \amoCRM\Entities\Filters\ContactsFilter
 */
final class ContactsFilterTest extends TestCase
{
    public function testInstanceOf()
    {
        $filter = new ContactsFilter();

        $this->assertInstanceOf(
            SearchFilter::class,
            $filter
        );

        $this->assertInstanceOf(
            BaseEntityFilter::class,
            $filter
        );
    }

    public function testCases()
    {
        $expected = [
            'type' => 'all',
        ];

        $filter = new ContactsFilter();
        $filter->setType($expected['type']);

        $this->assertEquals($expected, $filter->toArray());
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     * @expectedExceptionMessageRegExp /^Must on of \[[a-z, ]+\], but test given/
     */
    public function testThrowInvalidType()
    {
        (new ContactsFilter())->setType('test');
    }
}
