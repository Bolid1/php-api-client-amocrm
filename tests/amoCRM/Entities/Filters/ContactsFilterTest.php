<?php

namespace Tests\amoCRM\Entities\Filters;

use amoCRM\Entities\Filters\BaseEntityFilter;
use amoCRM\Entities\Filters\ContactsFilter;
use amoCRM\Entities\Filters\Interfaces\SearchFilter;
use PHPUnit\Framework\TestCase;

class ContactsFilterTest extends TestCase
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
            'id' => [1],
            'query' => 'test',
            'responsible_user_id' => [1],
            'type' => 'all',
        ];

        $filter = new ContactsFilter();
        $filter->setId($expected['id']);
        $filter->setQuery($expected['query']);
        $filter->setResponsibleUser($expected['responsible_user_id']);
        $filter->setType($expected['type']);

        $this->assertEquals($expected, $filter->toArray());
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Must be greater than zero, "0" given
     */
    public function testThrowNotPositiveId()
    {
        (new ContactsFilter())->setId(0);
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Must be greater than zero, "0" given
     */
    public function testThrowNotPositiveResponsibleUser()
    {
        (new ContactsFilter())->setResponsibleUser(0);
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
