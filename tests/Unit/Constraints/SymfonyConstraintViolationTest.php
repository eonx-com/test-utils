<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\Constraints;

use Eonx\TestUtils\Constraints\SymfonyConstraintViolation;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Tests\Eonx\TestUtils\Stubs\Vendor\Symfony\Validator\ConstraintViolationListStub;

/**
 * @covers \Eonx\TestUtils\Constraints\SymfonyConstraintViolation
 */
class SymfonyConstraintViolationTest extends TestCase
{
    /**
     * Create test cases to test for evaluate.
     *
     * @return mixed[]
     */
    public function generateTestEvaluateCases(): iterable
    {
        yield 'Invalid constraint violation list object' => [
        'list' => new stdClass(),
        'expected' => '',
        'error' => new AssertionFailedError(
            'Supplied list is not a valid constraint violation list.'
        )
    ];

        yield 'Custom constraint validation list has __toString()' =>
        [
            'list' => new ConstraintViolationListStub(),
            'expected' => '',
            'error' => new AssertionFailedError(
                'No __toString() method is available on the violation list'
            )
        ];

        yield 'Assertion passes when expected matches violation list' => [
            'list' => new ConstraintViolationList(
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
            ),
            'expected' => <<<'ERR'
amount.total:
    This value should be greater or equal to 0.
amount.currency:
    This value should not be null.

ERR,
            'error' => null
        ];

        yield 'Assertion fails when expected does not match violation list' => [
            'list' => new ConstraintViolationList(
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
            ),
            'expected' => <<<'ERR'
amount.random:
    A random error message that does not match the violation thrown.

ERR,
            'error' => new AssertionFailedError(
                'Failed asserting that expected errors match constraint violations.'
            )
        ];
    }

    /**
     * Test evaluate method.
     *
     * @param mixed $list mixed for testing purpose.
     * @param string $expected
     * @param \PHPUnit\Framework\AssertionFailedError|null $error
     *
     * @return void
     *
     * @dataProvider generateTestEvaluateCases
     */
    public function testEvaluate(
        $list,
        string $expected,
        ?AssertionFailedError $error
    ): void {
        $constraint = new SymfonyConstraintViolation($expected);

        if ($error !== null) {
            $this->expectException(AssertionFailedError::class);
            $this->expectExceptionMessage($error->getMessage());
        }

        $constraint->evaluate($list);

        $this->addToAssertionCount(1);
    }

    /**
     * Evaluate can be set to return a result via its parameters, test it does that.
     *
     * @return void
     */
    public function testEvaluateWhenItIsSetToReturnAResult(): void
    {
        $constraint = new SymfonyConstraintViolation('');
        $list = new ConstraintViolationList();

        $result = $constraint->evaluate($list, '', true);

        self::assertTrue($result);
    }
}
