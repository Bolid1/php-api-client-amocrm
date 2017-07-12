<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\BaseCustomField;
use amoCRM\Entity\BaseElement;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseElementTest
 * @package Tests\amoCRM\Entity
 * @covers \amoCRM\Entity\BaseElement
 */
final class BaseElementTest extends TestCase
{
    public function testSetId()
    {
        $stub = $this->buildMock();

        $id = 1;
        $stub->setId($id);

        $this->assertEquals(['id' => $id], $stub->toAmo());
    }

    /**
     * @return BaseElement
     */
    private function buildMock()
    {
        $stub = $this->getMockBuilder(BaseElement::class)
            ->disableOriginalConstructor()
            ->setMethods()
            ->getMock();

        /** @var BaseElement $stub */
        return $stub;
    }

    /**
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     */
    public function testSetIdThrowInvalidArgument()
    {
        $stub = $this->buildMock();

        $id = 0;
        $stub->setId($id);
    }

    public function testSetName()
    {
        $stub = $this->buildMock();

        $name = 'Some name';
        $stub->setName($name);

        $this->assertEquals(['name' => $name], $stub->toAmo());
    }

    public function testSetDateCreateTimestamp()
    {
        $stub = $this->buildMock();

        $date = time();
        $stub->setDateCreate($date);

        $this->assertEquals(['date_create' => $date], $stub->toAmo());
    }

    public function testSetDateCreateString()
    {
        $stub = $this->buildMock();

        $now = time();
        $date = date(\DateTime::ATOM, $now);
        $stub->setDateCreate($date);

        $this->assertEquals(['date_create' => $now], $stub->toAmo());
    }

    /**
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     */
    public function testSetDateCreateThrowInvalidArgument()
    {
        $this->buildMock()->setDateCreate('some string');
    }

    public function testSetCreatedBy()
    {
        $stub = $this->buildMock();

        $number = 10000;
        $stub->setCreatedBy($number);

        $this->assertEquals(['created_user_id' => $number], $stub->toAmo());
    }

    /**
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     */
    public function testSetCreatedByThrowInvalidArgument()
    {
        $this->buildMock()->setCreatedBy('some string');
    }

    public function testSetDateModify()
    {
        $stub = $this->buildMock();

        $date = time();
        $stub->setDateModify($date);

        $this->assertEquals(['last_modified' => $date], $stub->toAmo());
    }

    public function testSetDateModifyString()
    {
        $stub = $this->buildMock();

        $now = time();
        $date = date(\DateTime::ATOM, $now);
        $stub->setDateModify($date);

        $this->assertEquals(['last_modified' => $now], $stub->toAmo());
    }

    /**
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     */
    public function testSetDateModifyThrowInvalidArgument()
    {
        $this->buildMock()->setDateModify('some string');
    }

    public function testSetModifiedBy()
    {
        $stub = $this->buildMock();

        $number = 10000;
        $stub->setModifiedBy($number);

        $this->assertEquals(['modified_user_id' => $number], $stub->toAmo());
    }

    /**
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     */
    public function testSetModifiedByThrowInvalidArgument()
    {
        $this->buildMock()->setModifiedBy('some string');
    }

    public function testSetResponsible()
    {
        $stub = $this->buildMock();

        $number = 10000;
        $stub->setResponsible($number);

        $this->assertEquals(['responsible_user_id' => $number], $stub->toAmo());
    }

    /**
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     */
    public function testSetResponsibleThrowInvalidArgument()
    {
        $this->buildMock()->setResponsible('some string');
    }

    public function testAddCustomField()
    {
        $value = [['id' => 1, 'values' => [['value' => 'test']]]];
        $custom_field = $this->createMock(BaseCustomField::class);
        $custom_field->expects($this->once())
            ->method('toAmo')
            ->willReturn($value);

        $stub = $this->buildMock();

        $stub->addCustomField($custom_field);

        $this->assertEquals(['custom_fields' => [$value]], $stub->toAmo());
    }

    public function testAddTag()
    {
        $stub = $this->buildMock();

        $tag = 'foo';
        $stub->addTag($tag);

        $this->assertEquals(['tags' => $tag], $stub->toAmo());
    }

    public function testRemoveTag()
    {
        $stub = $this->buildMock();

        $tags = [
            'foo',
            'bar',
            'baz',
        ];
        foreach ($tags as $tag) {
            $stub->addTag($tag);
        }

        $this->assertEquals(['tags' => implode(',', $tags)], $stub->toAmo());

        $stub->removeTag($tags[1]);
        unset($tags[1]);
        $this->assertEquals(['tags' => implode(',', $tags)], $stub->toAmo());
    }

    public function testRemoveTagDoNothing()
    {
        $stub = $this->buildMock();
        $this->assertEquals([], $stub->toAmo());
        $stub->removeTag('foo');
        $this->assertEquals([], $stub->toAmo());
    }

    public function testAddEmptyTagDoNothing()
    {
        $stub = $this->buildMock();

        $tag = '';
        $stub->addTag($tag);

        $this->assertEquals(['tags' => $tag], $stub->toAmo());
    }

    public function testAddTags()
    {
        $stub = $this->buildMock();

        $tags = ['foo', 'bar'];
        $stub->addTags($tags);

        $this->assertEquals(['tags' => implode(',', $tags)], $stub->toAmo());
    }
}
