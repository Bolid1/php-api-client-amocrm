<?php

namespace Tests\amoCRM\Unsorted;

use amoCRM\Entity;
use amoCRM\Exception\InvalidResponseException;
use amoCRM\Interfaces\Requester;
use amoCRM\Unsorted\BaseUnsortedRequester;
use amoCRM\Unsorted\UnsortedForm;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseUnsortedRequesterTest
 * @package Tests\amoCRM\Unsorted
 * @covers \amoCRM\Unsorted\BaseUnsortedRequester
 */
final class BaseUnsortedRequesterTest extends TestCase
{
    public function testAddUnsorted()
    {
        $example = [
            'source' => 'http://example.info',
            'source_uid' => '1498585325fd4e2ca0e372af6593cd69a991d37585806383581',
            'source_data' => [
                'data' => [
                    'name_'.Entity\Contact::TYPE_NUMERIC => [
                        'type' => 'text',
                        'id' => 'name',
                        'element_type' => Entity\Contact::TYPE_NUMERIC,
                        'name' => 'ФИО',
                        'value' => '0c0gaCbr0',
                    ],
                    'name_'.Entity\Lead::TYPE_NUMERIC => [
                        'type' => 'text',
                        'id' => 'name',
                        'element_type' => Entity\Lead::TYPE_NUMERIC,
                        'name' => 'ФИО',
                        'value' => 'Lead name',
                    ],
                    '61237_'.Entity\Contact::TYPE_NUMERIC => [
                        'type' => 'multitext',
                        'id' => '61237',
                        'element_type' => Entity\Contact::TYPE_NUMERIC,
                        'name' => 'Телефон',
                        'value' => ['+7 999 999 99-99'],
                    ],
                    '61238_'.Entity\Lead::TYPE_NUMERIC => [
                        'type' => 'numeric',
                        'id' => '61238',
                        'element_type' => Entity\Lead::TYPE_NUMERIC,
                        'name' => 'Number',
                        'value' => 123,
                    ],
                    '61239_'.Entity\Contact::TYPE_NUMERIC => [
                        'type' => 'text',
                        'id' => '61239',
                        'element_type' => Entity\Contact::TYPE_NUMERIC,
                        'name' => 'Email',
                        'value' => 'test@example.com',
                    ],
                ],
                'form_id' => 180724,
                'form_type' => UnsortedForm::FORM_TYPE_ID_WORDPRESS,
                'origin' => [
                    'url' => 'https://example.com',
                    'request_id' => '1498585325fd4e2ca0e372af6593cd69a991d37585806383581',
                    'form_type' => UnsortedForm::FORM_TYPE_ID_WORDPRESS,
                ],
                'date' => 1498585317,
                'form_name' => 'My first form',
                'from' => 'http://example.info',
            ],
        ];

        $requester = $this->createMock(Requester::class);

        $unsorted = new UnsortedForm;
        $unsorted->setSource($example['source']);
        $unsorted->setSourceUid($example['source_uid']);
        $unsorted->setSourceData($example['source_data']);

        $post_data = [
            'request' => [
                'unsorted' => [
                    'category' => UnsortedForm::CATEGORY,
                    'add' => [
                        $unsorted->toAmo(),
                        $unsorted->toAmo(),
                    ],
                ],
            ],
        ];

        $success_result = [
            'unsorted' => [
                'add' => [
                    'status' => 'success',
                ],
            ],
        ];

        $failed_result = [
            'unsorted' => [
                'add' => [
                    'status' => 'fail',
                ],
            ],
        ];

        $invalid_result = [
            'unsorted' => [],
        ];

        $requester
            ->expects($this->exactly(3))
            ->method('post')->with(
                $this->equalTo(BaseUnsortedRequester::BASE_PATH . 'add/'),
                $this->equalTo($post_data)
            )
            ->willReturn($success_result, $failed_result, $invalid_result);

        /** @var BaseUnsortedRequester $stub */
        $stub = $this->getMockBuilder(BaseUnsortedRequester::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs([$requester, UnsortedForm::CATEGORY])
            ->setMethods()
            ->getMock();

        $this->assertTrue($stub->add([$unsorted, $unsorted->toAmo()]));
        $this->assertFalse($stub->add([$unsorted, $unsorted->toAmo()]));

        $this->expectException(InvalidResponseException::class);
        $stub->add([$unsorted, $unsorted->toAmo()]);
    }

    /**
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     */
    public function testAddUnsortedThrowInvalidArgumentException()
    {
        $requester = $this->createMock(Requester::class);

        /** @var BaseUnsortedRequester $stub */
        $stub = $this->getMockBuilder(BaseUnsortedRequester::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs([$requester, UnsortedForm::CATEGORY])
            ->setMethods()
            ->getMock();

        $stub->add(['test']);
    }
}
