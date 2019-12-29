<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\TestCases\UnitTestCase;

use Eonx\TestUtils\TestCases\UnitTestCase;
use PHPUnit\Framework\AssertionFailedError;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * @covers \Eonx\TestUtils\TestCases\UnitTestCase::assertConstraints
 */
class AssertConstraintTest extends UnitTestCase
{
    /**
     * Test assertion fails when violations don't match.
     *
     * @return void
     */
    public function testAssertionFailsWhenViolationsDontMatch(): void
    {
        $list = new ConstraintViolationList(
            [
                new ConstraintViolation(
                    'This value should be greater or equal to 0.',
                    null,
                    [],
                    'amount',
                    'total',
                    '1'
                )
            ]
        );

        // When the expected errors does not match the constraint violations, assertion fails.
        $expected = '';

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage('Failed asserting that expected errors match constraint violations.');

        self::assertConstraints($expected, $list);
    }

    /**
     * Test symfony violation constraints.
     *
     * @return void
     */
    public function testViolation(): void
    {
        $list = new ConstraintViolationList(
            [
                new ConstraintViolation(
                    'This value should be greater or equal to 0.',
                    null,
                    [],
                    'amount',
                    'total',
                    '1'
                ),
                new ConstraintViolation(
                    'This value should not be null.',
                    null,
                    [],
                    'amount',
                    'currency',
                    null
                )
            ]
        );

        $expected = <<<'ERR'
amount.total:
    This value should be greater or equal to 0.
amount.currency:
    This value should not be null.

ERR;

        self::assertConstraints($expected, $list);
    }
}
