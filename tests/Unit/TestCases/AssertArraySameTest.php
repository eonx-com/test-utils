<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\TestCases;

use Eonx\TestUtils\TestCases\UnitTestCase;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\ExpectationFailedException;

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
            ),
            'comparisionCreated' => true
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
     * @param array $expected
     * @param \PHPUnit\Framework\AssertionFailedError|null $error
     * @param bool|null $comparisionCreated To assert that a comparision diff was created.
     *
     * @return void
     *
     * @dataProvider generateTestCases
     */
    public function testAssertion(
        $actual,
        array $expected,
        ?AssertionFailedError $error,
        ?bool $comparisionCreated = null
    ): void {
        if ($error instanceof AssertionFailedError === true) {
            $this->expectException(
                $comparisionCreated ?
                    ExpectationFailedException::class :
                    AssertionFailedError::class
            );
            $this->expectExceptionMessage($error->getMessage());
        }

        self::assertArrayFuzzy($expected, $actual);
    }
}
