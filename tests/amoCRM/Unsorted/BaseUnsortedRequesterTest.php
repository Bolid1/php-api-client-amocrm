<?php

namespace Tests\amoCRM\Unsorted;

use amoCRM\Interfaces\Requester;
use amoCRM\Unsorted\UnsortedForm;
use PHPUnit\Framework\TestCase;
use amoCRM\Unsorted\BaseUnsortedRequester;
use amoCRM\Entities\Elements;

class BaseUnsortedRequesterTest extends TestCase
{
    private $_unsorted = [
        'source' => 'http://OulVKvE5.info',
        'source_uid' => '1498585325fd4e2ca0e372af6593cd69a991d37585806383581',
        'source_data' => [
            'data' => [
                'name_' . Elements\Contact::TYPE_NUMERIC => [
                    'type' => 'text',
                    'id' => 'name',
                    'element_type' => Elements\Contact::TYPE_NUMERIC,
                    'name' => 'ФИО',
                    'value' => '0c0gaCbr0',
                ],
                'name_' . Elements\Lead::TYPE_NUMERIC => [
                    'type' => 'text',
                    'id' => 'name',
                    'element_type' => Elements\Lead::TYPE_NUMERIC,
                    'name' => 'ФИО',
                    'value' => 'Lead name',
                ],
                '61237_' . Elements\Contact::TYPE_NUMERIC => [
                    'type' => 'multitext',
                    'id' => '61237',
                    'element_type' => Elements\Contact::TYPE_NUMERIC,
                    'name' => 'Телефон',
                    'value' => ['odhgPM'],
                ],
                '61238_' . Elements\Lead::TYPE_NUMERIC => [
                    'type' => 'numeric',
                    'id' => '61238',
                    'element_type' => Elements\Lead::TYPE_NUMERIC,
                    'name' => 'Number',
                    'value' => 123,
                ],
                '61239_' . Elements\Contact::TYPE_NUMERIC => [
                    'type' => 'text',
                    'id' => '61239',
                    'element_type' => Elements\Contact::TYPE_NUMERIC,
                    'name' => 'Email',
                    'value' => 'jGHVE9@7nTX.YmgGIlVzi.xWK.org',
                ],
            ],
            'form_id' => 180724,
            'form_type' => UnsortedForm::FORM_TYPE_ID_WORDPRESS,
            'origin' => [
                'url' => 'https://D33.wu8s.com',
                'request_id' => '1498585325fd4e2ca0e372af6593cd69a991d37585806383581',
                'form_type' => UnsortedForm::FORM_TYPE_ID_WORDPRESS,
            ],
            'date' => 1498585317,
            'form_name' => 'kRq0ZD2DZHV',
            'from' => 'http://OulVKvE5.info',
        ],
    ];

    public function testAddUnsorted()
    {
        $requester = $this->createMock(Requester::class);

        $unsorted = new UnsortedForm;
        $unsorted->setSource($this->_unsorted['source']);
        $unsorted->setSourceUid($this->_unsorted['source_uid']);
        $unsorted->setSourceData($this->_unsorted['source_data']);

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
            ->setMethods(null)
            ->getMock();

        $this->assertTrue($stub->add([$unsorted, $unsorted->toAmo()]));
        $this->assertFalse($stub->add([$unsorted, $unsorted->toAmo()]));

        $this->expectException('\amoCRM\Exceptions\InvalidResponseException');
        $stub->add([$unsorted, $unsorted->toAmo()]);
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testAddUnsortedThrowInvalidArgumentException()
    {
        $requester = $this->createMock(Requester::class);

        /** @var BaseUnsortedRequester $stub */
        $stub = $this->getMockBuilder(BaseUnsortedRequester::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs([$requester, UnsortedForm::CATEGORY])
            ->setMethods(null)
            ->getMock();

        $stub->add(['test']);
    }
}
