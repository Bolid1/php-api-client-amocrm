<?php

namespace Tests\amoCRM\Filter;

use amoCRM\Filter\BaseEntityFilter;
use amoCRM\Filter\ContactsFilter;
use amoCRM\Filter\Interfaces\SearchFilter;
use PHPUnit\Framework\TestCase;

/**
 * Class ContactsFilterTest
 * @package Tests\amoCRM\Filter
 */
final class ContactsFilterTest extends TestCase
{
    /**
     * @coversNothing
     */
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

    /**
     * @covers \amoCRM\Filter\ContactsFilter::setType
     * @covers \amoCRM\Filter\ContactsFilter::toArray
     */
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
     * @covers \amoCRM\Filter\ContactsFilter::setType
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     * @expectedExceptionMessageRegExp /^Must on of \[[a-z, ]+\], but test given/
     */
    public function testThrowInvalidType()
    {
        (new ContactsFilter())->setType('test');
    }
}
