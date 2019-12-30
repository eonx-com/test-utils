<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\Constraints;

use Eonx\TestUtils\Constraints\RequestProperties;
use Eonx\TestUtils\TestCases\UnitTestCase;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\ExpectationFailedException;
use stdClass;
use Tests\Eonx\TestUtils\Stubs\Helpers\RequestObjects\TestRequestStub;

/**
 * @covers \Eonx\TestUtils\Constraints\RequestProperties
 */
class RequestPropertiesTest extends UnitTestCase
{
    /**
     * Generate test cases to test constraint.
     *
     * @return mixed[]
     */
    public function generateTestCases(): iterable
    {
        yield 'When expected does not match request object.' => [
            'object' => new TestRequestStub(true, 'John'),
            'expected' => ['active' => false, 'name' => 'Doe'],
            'exception' => new AssertionFailedError(
                'Failed asserting that request object matches expected array.'
            ),
            // To assert that a visual diff was created between actual and expected.
            'diffGenerated' => true
        ];

        yield 'When request object is not a valid instance.' => [
            'object' => new stdClass(),
            'expected' => [],
            'exception' => new AssertionFailedError(
                'Failed asserting that supplied object is a valid request object.'
            ),
            'diffGenerated' => false
        ];

        yield 'When expected matches request object.' => [
            'object' => new TestRequestStub(true, 'John'),
            'expected' => ['name' => 'John', 'active' => true],
            'exception' => null,
            'diffGenerated' => false
        ];
    }

    /**
     * Test constraint against data provider.
     *
     * @param mixed $object
     * @param mixed[] $expected
     * @param \PHPUnit\Framework\AssertionFailedError|null $exception
     * @param bool $diffGenerated
     *
     * @return void
     *
     * @dataProvider generateTestCases
     */
    public function testConstraint(
        $object,
        array $expected,
        ?AssertionFailedError $exception,
        bool $diffGenerated
    ): void {
        $constraint = new RequestProperties($expected);

        if ($exception !== null) {
            $this->expectException(AssertionFailedError::class);
            $this->expectExceptionMessage($exception->getMessage());
        }

        try {
            $constraint->evaluate($object);
        } catch (ExpectationFailedException $failedError) {
            if ($diffGenerated === true) {
                self::assertNotNull(
                    $failedError->getComparisonFailure(),
                    'A difference was not generated for this test.'
                );
            }

            if ($diffGenerated === false) {
                self::assertNull(
                    $failedError->getComparisonFailure(),
                    'A difference was generated for this test.'
                );
            }

            // rethrow error.
            throw $failedError;
        }

        $this->addToAssertionCount(1);
    }

    /**
     * Evaluate can be asked to return boolean instead of throwing an error.
     *
     * @return void
     */
    public function testEvaluateReturnsBoolean(): void
    {
        $requestObject = new TestRequestStub(true, 'John');
        $constraint = new RequestProperties([]);

        $result = $constraint->evaluate($requestObject, '', true);

        self::assertFalse($result);
    }
}
