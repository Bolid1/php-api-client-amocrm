<?php

namespace Tests\amoCRM\Entity;

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
            'note_type' => Note::N_TYPE_COMMON,
        ];
        $note = new Note;
        $this->assertEquals($expected, $note->toAmo());
    }
}
