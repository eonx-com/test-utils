<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\Constraints;

use Eonx\TestUtils\Constraints\ArraySame;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Eonx\TestUtils\Constraints\ArraySame
 */
class ArraySameTest extends TestCase
{
    /**
     * Test cases to test array same with fuzzy
     *
     * @return mixed[]
     */
    public function generateTestCases(): iterable
    {
        yield 'When arrays are same without fuzzy' => [
            'actual' => ['key' => 'value'],
            'expected' => ['key' => 'value'],
            'exception' => null
        ];

        yield 'Test array same with fuzzy' =>
        [
            'actual' => ['key' => 'value', 'date' => '2010-10-10T01:03:06Z'],
            'expected' => ['key' => 'value', 'date' => ':fuzzy:'],
            'exception' => null
        ];

        yield 'Test array same fails' =>
        [
            'actual' => ['key' => 'value'],
            'expected' => ['key' => 'missing'],
            'exception' => new AssertionFailedError(
                'Failed asserting that two arrays are identical.'
            ),
            'comparisionCreated' => true
        ];

        yield 'Test when actual is not an array' =>
        [
            'actual' => '',
            'expected' => ['key' => 'value'],
            'exception' => new AssertionFailedError('Failed asserting that string is an array.')
        ];
    }

    /**
     * Test evaluating array same constraint.
     *
     * @param mixed $actual
     * @param array $expected
     * @param \PHPUnit\Framework\AssertionFailedError|null $error
     * @param bool|null $comparisionCreated
     *
     * @return void
     *
     * @dataProvider generateTestCases
     */
    public function testEvaluate(
        $actual,
        array $expected,
        ?AssertionFailedError $error,
        ?bool $comparisionCreated = null
    ): void {
        $constraint = new ArraySame($expected);

        if ($error instanceof AssertionFailedError === true) {
            $this->expectException(
                $comparisionCreated ?
                    ExpectationFailedException::class :
                    AssertionFailedError::class
            );
            $this->expectExceptionMessage($error->getMessage());
        }

        $constraint->evaluate($actual);

        $this->addToAssertionCount(1);
    }

    /**
     * Test to string representation of the constraint.
     * This method won't be called on actual constraint ever, as
     * the constraint passes control to IsIdentical constraint.
     *
     * @return void
     */
    public function testToString(): void
    {
        $constraint = new ArraySame([]);

        $string = 'is same as Array &0 ()';

        self::assertSame($string, $constraint->toString());
    }
}
