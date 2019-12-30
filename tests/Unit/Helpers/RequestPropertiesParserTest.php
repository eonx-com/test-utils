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
        $object = new TestRequestStub(true, 'test');

        // get's are processed before is's, thus they up on list.
        $expected = [
            'name' => 'test',
            'active' => true
        ];

        $helper = new RequestPropertiesParser();

        $properties = $helper->get($object);

        static::assertSame($expected, $properties);
    }
}
