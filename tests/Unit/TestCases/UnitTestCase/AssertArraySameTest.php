<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\TestCases\UnitTestCase;

use Eonx\TestUtils\TestCases\UnitTestCase;
use PHPUnit\Framework\AssertionFailedError;

/**
 * @covers \Eonx\TestUtils\TestCases\UnitTestCase::assertArrayFuzzy
 */
class AssertArraySameTest extends UnitTestCase
{
    /**
     * Test cases to test array same with fuzzy
     *
     * @return mixed[]
     */
    public function generateTestCases(): iterable
    {
        yield 'Test array same fails' =>
        [
            'actual' => ['key' => 'value'],
            'expected' => ['key' => 'missing'],
            'exception' => new AssertionFailedError(
                'Failed asserting that two arrays are identical.'
            )
        ];

        yield 'Test array same with fuzzy' =>
        [
            'actual' => ['key' => 'value', 'date' => '2010-10-10T01:03:06Z'],
            'expected' => ['key' => 'value', 'date' => ':fuzzy:'],
            'exception' => null
        ];

        yield 'When arrays are same without fuzzy' => [
            'actual' => ['key' => 'value'],
            'expected' => ['key' => 'value'],
            'exception' => null
        ];
    }

    /**
     * Test evaluating array same constraint.
     *
     * @param mixed $actual
     * @param mixed[] $expected
     * @param \PHPUnit\Framework\AssertionFailedError|null $error
     *
     * @return void
     *
     * @dataProvider generateTestCases
     */
    public function testAssertion(
        $actual,
        array $expected,
        ?AssertionFailedError $error
    ): void {
        if ($error !== null) {
            $this->expectException(AssertionFailedError::class);
            $this->expectExceptionMessage($error->getMessage());
        }

        self::assertArrayFuzzy($expected, $actual);
    }
}
