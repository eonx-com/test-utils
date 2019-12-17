<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\Constraints;

use Eonx\TestUtils\Constraints\DoctrineUnitOfWorkEmpty;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use stdClass;
use Tests\Eonx\TestUtils\Stubs\Vendor\Doctrine\UnitOfWorkStub;

/**
 * @covers \Eonx\TestUtils\Constraints\DoctrineUnitOfWorkEmpty
 */
class DoctrineUnitOfWorkEmptyTest extends TestCase
{
    /**
     * Test fails when object is not a valid unit of work instance.
     *
     * @return void
     */
    public function testFailWhenUnitOfWorkIsNotAValidObject(): void
    {
        $constraint = new DoctrineUnitOfWorkEmpty();

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage('Supplied object is not a valid UnitOfWork instance.');

        $constraint->evaluate(new stdClass());
    }

    /**
     * Test failing case.
     *
     * @return void
     */
    public function testFailingCase(): void
    {
        $constraint = new DoctrineUnitOfWorkEmpty();

        $unitOfWork = new UnitOfWorkStub(
            [new stdClass()],
            [new stdClass()],
        );

        // Expected an exception which has comparision diff
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Failed asserting that unit of work has no pending changes');

        try {
            $constraint->evaluate($unitOfWork);
        } catch (ExpectationFailedException $exception) {
            self::assertNotNull(
                $exception->getComparisonFailure(),
                'A difference was not generated for this test case.'
            );

            throw $exception;
        }
    }

    /**
     * Test passing case.
     *
     * @return void
     */
    public function testPassingCase(): void
    {
        $constraint = new DoctrineUnitOfWorkEmpty();

        $unitOfWork = new UnitOfWorkStub();

        $result = $constraint->evaluate($unitOfWork, '', true);

        self::assertTrue($result);
    }
}
