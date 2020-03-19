<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\TestCases\UnitTestCase;

use Eonx\TestUtils\TestCases\UnitTestCase;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\ExpectationFailedException;

/**
 * @covers \Eonx\TestUtils\TestCases\UnitTestCase::assertJsonEqualsStringFuzzily
 */
class AssertJsonEqualsStringFuzzilyTest extends UnitTestCase
{
    /**
     * Assert that json can be asserted against its decoded array representation.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testJsonSameAsArray(): void
    {
        $json = '{"abc": "xyz", "date": "2019-10-10T01:04:45Z"}';
        $expected = ['abc' => 'xyz', 'date' => ':fuzzy:'];

        self::assertJsonEqualsStringFuzzily($expected, $json);
    }

    /**
     * Assert that json can be asserted against its decoded array representation.
     * In this case the test fails.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testJsonSameAsArrayFails(): void
    {
        $json = '{"abc": "xyz", "date": "2019-10-10T01:04:45Z"}';
        $expected = ['xyz' => 'abc', 'date' => ':fuzzy:'];

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Failed asserting that two arrays are equal.');

        self::assertJsonEqualsStringFuzzily($expected, $json);
    }

    /**
     * Assert that json can be asserted against its decoded array representation.
     * In this case the test fails.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testJsonSameAsArrayWithInvalidJson(): void
    {
        $json = '{"abc": "xyz}';
        $expected = ['abc' => 'xyz'];

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            <<<EOF
Failed asserting that '{"abc": "xyz}' is valid JSON (Unexpected control character found).
EOF
        );

        self::assertJsonEqualsStringFuzzily($expected, $json);
    }
}
