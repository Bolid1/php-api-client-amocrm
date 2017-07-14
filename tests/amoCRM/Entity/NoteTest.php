<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\Contact;
use amoCRM\Entity\Note;
use PHPUnit\Framework\TestCase;

/**
 * Class NoteTest
 * @package Tests\amoCRM\Entity
 */
final class NoteTest extends TestCase
{
    /** @covers \amoCRM\Entity\Note::getTypes */
    public function testGetTypes()
    {
        $expected = [
            Note::N_TYPE_LEAD_CREATED,
            Note::N_TYPE_CONTACT_CREATED,
            Note::N_TYPE_LEAD_STATUS_CHANGED,
            Note::N_TYPE_COMMON,
            Note::N_TYPE_FILE,
            Note::N_TYPE_IPHONE_CALL,
            Note::N_TYPE_CALL_IN,
            Note::N_TYPE_CALL_OUT,
            Note::N_TYPE_COMPANY_CREATED,
            Note::N_TYPE_TASK_RESULT,
            Note::N_TYPE_CUSTOMER_CREATED,
        ];

        $this->assertEquals($expected, Note::getTypes());
    }

    /**
     * @covers \amoCRM\Entity\Note::ensureValidType
     */
    public function testEnsureValidNoteType()
    {
        Note::ensureValidType(Note::N_TYPE_CALL_IN);
        $this->assertTrue(true);
    }

    /**
     * @covers \amoCRM\Entity\Note::ensureValidType
     * @expectedException \amoCRM\Exception\ValidateException
     */
    public function testEnsureValidNoteTypeThrows()
    {
        Note::ensureValidType('test');
    }

    /** @covers \amoCRM\Entity\Note::toAmo */
    public function testToAmo()
    {
        $expected = [
            'id' => 2,
            'element_id' => 2,
            'element_type' => 2,
            'note_type' => Note::N_TYPE_CALL_IN,
            'date_create' => time(),
            'last_modified' => time(),
            'modified_user_id' => 2,
            'text' => 'test',
            'responsible_user_id' => 2,
            'created_user_id' => 2,
        ];
        $note = new Note;

        $note->setId($expected['id']);
        $note->setElementId($expected['element_id']);
        $note->setElementType($expected['element_type']);
        $note->setType($expected['note_type']);
        $note->setDateCreate($expected['date_create']);
        $note->setDateModify($expected['last_modified']);
        $note->setModifiedBy($expected['modified_user_id']);
        $note->setText($expected['text']);
        $note->setResponsible($expected['responsible_user_id']);
        $note->setCreatedBy($expected['created_user_id']);

        $this->assertEquals($expected, $note->toAmo());
    }

    /**
     * @covers \amoCRM\Entity\Note::setId
     * @covers \amoCRM\Entity\Note::getId
     */
    public function testSetId()
    {
        $value = 1;
        $note = new Note;
        $note->setId($value);
        $this->assertEquals($value, $note->getId());
    }

    /**
     * @covers \amoCRM\Entity\Note::setElementId
     * @covers \amoCRM\Entity\Note::getElementId
     */
    public function testSetElementId()
    {
        $value = 1;
        $note = new Note;
        $note->setElementId($value);
        $this->assertEquals($value, $note->getElementId());
    }

    /**
     * @covers \amoCRM\Entity\Note::setElementType
     * @covers \amoCRM\Entity\Note::ensureValidElementType
     * @covers \amoCRM\Entity\Note::getElementType
     */
    public function testSetElementType()
    {
        $value = Contact::TYPE_NUMERIC;
        $note = new Note;
        $note->setElementType($value);
        $this->assertEquals($value, $note->getElementType());
    }

    /**
     * @covers \amoCRM\Entity\Note::ensureValidElementType
     * @uses   \amoCRM\Entity\Note::setElementType
     * @expectedException \amoCRM\Exception\ValidateException
     */
    public function testSetElementTypeThrowInvalidArgument()
    {
        $value = 'test';
        $note = new Note;
        $note->setElementType($value);
    }

    /**
     * @covers \amoCRM\Entity\Note::setDateCreate
     * @covers \amoCRM\Entity\Note::getDateCreate
     */
    public function testSetDateCreate()
    {
        $value = time();
        $note = new Note;
        $note->setDateCreate($value);
        $this->assertEquals($value, $note->getDateCreate());
    }

    /**
     * @covers \amoCRM\Entity\Note::setDateModify
     * @covers \amoCRM\Entity\Note::getDateModify
     */
    public function testSetDateModify()
    {
        $value = time();
        $note = new Note;
        $note->setDateModify($value);
        $this->assertEquals($value, $note->getDateModify());
    }

    /**
     * @covers \amoCRM\Entity\Note::setModifiedBy
     * @covers \amoCRM\Entity\Note::getModifiedBy
     */
    public function testSetModifiedBy()
    {
        $value = 1;
        $note = new Note;
        $note->setModifiedBy($value);
        $this->assertEquals($value, $note->getModifiedBy());
    }

    /**
     * @covers \amoCRM\Entity\Note::setType
     * @covers \amoCRM\Entity\Note::getType
     */
    public function testSetType()
    {
        $value = Note::N_TYPE_COMMON;
        $note = new Note;
        $note->setType($value);
        $this->assertEquals($value, $note->getType());
    }

    /**
     * @covers \amoCRM\Entity\Note::setText
     * @covers \amoCRM\Entity\Note::getText
     */
    public function testSetText()
    {
        $value = 'some text';
        $note = new Note;
        $note->setText($value);
        $this->assertEquals($value, $note->getText());
    }

    /**
     * @covers \amoCRM\Entity\Note::setResponsible
     * @covers \amoCRM\Entity\Note::getResponsible
     */
    public function testSetResponsible()
    {
        $value = 1;
        $note = new Note;
        $note->setResponsible($value);
        $this->assertEquals($value, $note->getResponsible());
    }

    /**
     * @covers \amoCRM\Entity\Note::setCreatedBy
     * @covers \amoCRM\Entity\Note::getCreatedBy
     */
    public function testSetCreatedBy()
    {
        $value = 1;
        $note = new Note;
        $note->setCreatedBy($value);
        $this->assertEquals($value, $note->getCreatedBy());
    }
}
