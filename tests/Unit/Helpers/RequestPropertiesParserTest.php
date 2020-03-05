<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\Helpers;

use Eonx\TestUtils\Helpers\RequestPropertiesParser;
use Eonx\TestUtils\TestCases\UnitTestCase;
use Tests\Eonx\TestUtils\Stubs\Helpers\RequestObjects\TestRequestStub;

/**
 * @covers \Eonx\TestUtils\Helpers\RequestPropertiesParser
 */
class RequestPropertiesParserTest extends UnitTestCase
{
    /**
     * Test getting request properties into an array.
     *
     * @return void
     */
    public function testGetRequestProperties(): void
    {
        $object = new TestRequestStub(
            true,
            'test',
            new TestRequestStub(false, 'deeper'),
            [new TestRequestStub(false, 'deeper2')]
        );

        // get's are processed before is's, thus they up on list.
        $expected = [
            'deeper' => [
                'deeper' => null,
                'evenDeeper' => [],
                'name' => 'deeper',
                'active' => false
            ],
            'evenDeeper' => [
                [
                    'deeper' => null,
                    'evenDeeper' => [],
                    'name' => 'deeper2',
                    'active' => false
                ]
            ],
            'name' => 'test',
            'active' => true,
        ];

        $helper = new RequestPropertiesParser();

        $properties = $helper->get($object);

        static::assertSame($expected, $properties);
    }
}
