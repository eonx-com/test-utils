<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\Constraints;

use DateTime;
use Eonx\TestUtils\Constraints\ArraySameWithDates;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Eonx\TestUtils\Constraints\ArraySameWithDates
 */
class ArraySameWithDatesTest extends TestCase
{
    /**
     * Test to make sure evaluate works as expected.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testEvaluate(): void
    {
        $actual = [
            'random' => 'value',
            'date' => new DateTime('2019-10-10T00:00:00Z'),
            'deep' => [
                'deeper' => [
                    'date' => new DateTime('2019-10-10T00:00:00+0000'),
                ]
            ]
        ];

        $expected = [
            'random' => 'value',
            'date' => new DateTime('2019-10-10T00:00:00Z'),
            'deep' => [
                'deeper' => [
                    'date' => new DateTime('2019-10-10T00:00:00+0000'),
                ]
            ]
        ];

        $constraint = new ArraySameWithDates($expected);
        $result = $constraint->evaluate($actual, '', true);

        self::assertTrue($result);
    }

    /**
     * Test evaluate fails when the arrays don't match.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testEvaluateFailsWhenArrayNotSame(): void
    {
        $actual = [
            'random' => 'value',
            'date' => new DateTime('2019-10-10T01:01:01Z'),
            'deep' => [
                'deeper' => [
                    'date' => new DateTime('2019-10-10T00:00:00+0000'),
                ]
            ]
        ];

        $expected = [
            'random' => 'value',
            'date' => new DateTime('2019-10-10T00:00:00Z'),
            'deep' => [
                'deeper' => [
                    'date' => new DateTime('2019-10-10T00:00:00+0000'),
                ]
            ]
        ];

        $constraint = new ArraySameWithDates($expected);
        $result = $constraint->evaluate($actual, '', true);

        self::assertFalse($result);
    }

    /**
     * Assert that evaluate returns early when arrays don't contain any objects
     * to compare. In that case it can use simple === comparator to make sure
     * arrays are same.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testEvaluateReturnsEarlyWhenArraysSame(): void
    {
        $actual = [
            'random' => 'value'
        ];

        $expected = [
            'random' => 'value'
        ];

        $constraint = new ArraySameWithDates($expected);
        $result = $constraint->evaluate($actual, '', true);

        self::assertTrue($result);
    }

    /**
     * Test to string returns expected string error.
     *
     * @return void
     */
    public function testToString(): void
    {
        $constraint = new ArraySameWithDates([]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(<<<EOF
'' is same as Array &0 ()
EOF
        );
        $constraint->evaluate('');
    }
}
