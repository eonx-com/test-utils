<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\Validation;

use Eonx\TestUtils\TestCases\TestCase;
use Eonx\TestUtils\Validation\CodeCoverageValidator;

/**
 * @covers \Eonx\TestUtils\Validation\CodeCoverageValidator
 */
class CodeCoverageValidatorTest extends TestCase
{
    /**
     * Tests that the validator returns an array of files (as expected when run against src).
     *
     * @return void
     */
    public function testNotCovered(): void
    {
        $validator = new CodeCoverageValidator();

        $srcDir = $this->getProjectPath() . \DIRECTORY_SEPARATOR . 'src';

        $missing = $validator->findFilesWithoutCovers($srcDir);

        // Assert that the missing array contains records
        self::assertGreaterThanOrEqual(1, \count($missing));
    }

    /**
     * Tests that the validator returns an array of files (as expected when run against src).
     *
     * @return void
     */
    public function testCovered(): void
    {
        $validator = new CodeCoverageValidator();

        $missing = $validator->findFilesWithoutCovers(__DIR__);

        // Assert that the missing array contains nothing.
        self::assertCount(0, $missing);
    }
}
