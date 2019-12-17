<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\TestCases;

use Eonx\TestUtils\TestCases\UnitTestCase;
use PHPUnit\Framework\ExpectationFailedException;
use stdClass;
use Tests\Eonx\TestUtils\Stubs\Vendor\Doctrine\UnitOfWorkStub;

/**
 * @covers \Eonx\TestUtils\TestCases\UnitTestCase::assertUnitOfWorkIsEmpty
 */
class AssertUnitOfWorkEmptyTest extends UnitTestCase
{
    /**
     * Test asserting unit of work is empty fails.
     *
     * @return void
     */
    public function testAssertionFails(): void
    {
        $unitOfWork = new UnitOfWorkStub([new stdClass()]);

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Failed asserting that unit of work has no pending changes.');

        try {
            self::assertUnitOfWorkIsEmpty($unitOfWork);
        }catch (ExpectationFailedException $exception){
            self::assertNotNull(
                $exception->getComparisonFailure(),
                'A difference comparision should have been generated.'
            );

            throw $exception;
        }
    }

    /**
     * Test asserting unit of work is empty.
     *
     * @return void
     */
    public function testAssertionPasses(): void
    {
        // empty constructor means no pending changes
        $unitOfWork = new UnitOfWorkStub();

        self::assertUnitOfWorkIsEmpty($unitOfWork);
    }
}
