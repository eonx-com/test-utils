<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\Tests\Validation;

use Eonx\TestUtils\TestCases\TestCase;
use Eonx\TestUtils\Tests\Validation\CoversTest;
use PHPUnit\Framework\AssertionFailedError;
use Tests\Eonx\TestUtils\Stubs\Validation\CodeCoverageValidatorStub;

/**
 * @covers \Eonx\TestUtils\Tests\Validation\CoversTest
 */
class CoversTestTest extends TestCase
{
    /**
     * Tests that the test will fail when there are missing covers.
     *
     * @return void
     */
    public function testMissingCovers(): void
    {
        $validator = new CodeCoverageValidatorStub(['missing']);
        $test = new CoversTest(null, null, null, $validator);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage('Test file (missing) does not contain @covers or @coversNothing');

        $test->testAllTestsContainCoversAnnotation();
    }

    /**
     * Tests that the test will succeed when there are no missing covers.
     *
     * @return void
     */
    public function testNoMissingCovers(): void
    {
        $validator = new CodeCoverageValidatorStub([]);
        $test = new CoversTest(null, null, null, $validator);

        $test->testAllTestsContainCoversAnnotation();

        self::assertSame(1, $test->getNumAssertions());
    }
}
