<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\Constraints;

use Eonx\TestUtils\Constraints\ArraySame;
use Eonx\TestUtils\TestCases\UnitTestCase;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\ExpectationFailedException;

/**
 * @covers \Eonx\TestUtils\Constraints\ArraySame
 */
class ArraySameTest extends UnitTestCase
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
            'exception' => new AssertionFailedError('Failed asserting that string is an array.'),
            'comparisionCreated' => false
        ];
    }

    /**
     * Test evaluating array same constraint.
     *
     * @param mixed $actual
     * @param mixed[] $expected
     * @param \PHPUnit\Framework\AssertionFailedError|null $error
     * @param bool|null $comparisionCreated Assert if an comparision diff was generated.
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

        if ($error !== null) {
            $this->expectException(AssertionFailedError::class);
            $this->expectExceptionMessage($error->getMessage());
        }

        try {
            $constraint->evaluate($actual);
        } catch (ExpectationFailedException $exception) {
            if ($comparisionCreated === true) {
                self::assertNotNull(
                    $exception->getComparisonFailure(),
                    'A difference was not generated for this test.'
                );
            }

            if ($comparisionCreated === false) {
                self::assertNull(
                    $exception->getComparisonFailure(),
                    'A difference was generated for this test.'
                );
            }

            // rethrow error.
            throw $exception;
        }

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
