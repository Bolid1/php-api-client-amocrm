<?php

namespace Tests\amoCRM\Filter;

use amoCRM\Entity;
use amoCRM\Filter\Interfaces\SearchFilter;
use amoCRM\Filter\NotesFilter;
use PHPUnit\Framework\TestCase;

/**
 * Class NotesFilterTest
 * @package Tests\amoCRM\Filter
 */
final class NotesFilterTest extends TestCase
{
    /** @coversNothing */
    public function testInstanceOf()
    {
        $this->assertInstanceOf(
            SearchFilter::class,
            new NotesFilter
        );
    }

    /**
     * @covers \amoCRM\Filter\NotesFilter::setId
     * @covers \amoCRM\Filter\NotesFilter::getId
     */
    public function testGetId()
    {
        $value = 1;
        $filter = new NotesFilter;
        $filter->setId($value);
        $this->assertEquals([$value], $filter->getId());
    }

    /**
     * @covers \amoCRM\Filter\NotesFilter::setElementType
     * @covers \amoCRM\Filter\NotesFilter::ensureValidElementType
     * @covers \amoCRM\Filter\NotesFilter::getElementType
     */
    public function testGetElementType()
    {
        $value = NotesFilter::ELEMENT_TYPE_LEAD;
        $filter = new NotesFilter;
        $filter->setElementType($value);
        $this->assertEquals($value, $filter->getElementType());
    }

    /**
     * @covers \amoCRM\Filter\NotesFilter::setElementType
     * @covers \amoCRM\Filter\NotesFilter::ensureValidElementType
     * @expectedException \amoCRM\Exception\ValidateException
     */
    public function testThrowInvalidElementType()
    {
        $filter = new NotesFilter;
        $filter->setElementType('test');
    }

    /**
     * @covers \amoCRM\Filter\NotesFilter::setElementId
     * @covers \amoCRM\Filter\NotesFilter::getElementId
     */
    public function testGetElementId()
    {
        $value = 1;
        $filter = new NotesFilter;
        $filter->setElementId($value);
        $this->assertEquals([$value], $filter->getElementId());
    }

    /**
     * @covers \amoCRM\Filter\NotesFilter::setNotesType
     * @covers \amoCRM\Filter\NotesFilter::getNotesType
     */
    public function testGetNotesType()
    {
        $value = Entity\Note::N_TYPE_CALL_IN;
        $filter = new NotesFilter;
        $filter->setNotesType($value);
        $this->assertEquals([$value], $filter->getNotesType());
    }

    /**
     * @covers \amoCRM\Filter\NotesFilter::getElementTypes
     */
    public function testGetElementTypes()
    {
        $notes_elements_types = [
            Entity\Contact::TYPE_SINGLE,
            Entity\Lead::TYPE_SINGLE,
            Entity\Company::TYPE_SINGLE,
            Entity\Task::TYPE_SINGLE,
        ];

        $this->assertEquals($notes_elements_types, NotesFilter::getElementTypes());
    }

    /**
     * @covers \amoCRM\Filter\NotesFilter::toArray
     * @uses   \amoCRM\Filter\NotesFilter::setId
     * @uses   \amoCRM\Filter\NotesFilter::setElementId
     */
    public function testToArray()
    {
        $expected = [
            'id' => [1, 2, 3],
            'type' => Entity\Contact::TYPE_SINGLE,
            'element_id' => [4, 5, 6],
        ];

        $filter = new NotesFilter;

        $filter->setId($expected['id']);
        $filter->setElementType($expected['type']);
        $filter->setElementId($expected['element_id']);

        $this->assertEquals($expected, $filter->toArray());
    }
}
