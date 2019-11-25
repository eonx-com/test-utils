<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Tests\Validation;

use Eonx\TestUtils\TestCases\TestCase;
use Eonx\TestUtils\Validation\CodeCoverageValidator;
use Eonx\TestUtils\Validation\Interfaces\CodeCoverageValidatorInterface;

/**
 * Tests that all files inside the test directory have a covers annotation
 * on them.
 *
 * @coversNothing
 */
final class CoversTest extends TestCase
{
    /**
     * @var \Eonx\TestUtils\Validation\Interfaces\CodeCoverageValidatorInterface
     */
    private $validator;

    /**
     * Constructor
     *
     * @param string|null $name
     * @param mixed[]|null $data
     * @param string|null $dataName
     * @param \Eonx\TestUtils\Validation\Interfaces\CodeCoverageValidatorInterface|null $validator
     */
    public function __construct(
        ?string $name = null,
        ?array $data = null,
        ?string $dataName = null,
        ?CodeCoverageValidatorInterface $validator = null
    ) {
        parent::__construct($name, $data ?? [], $dataName ?? '');

        $this->validator = $validator ?? new CodeCoverageValidator();
    }

    /**
     * Test all tests contains a covers* annotation
     *
     * @return void
     */
    public function testAllTestsContainCoversAnnotation(): void
    {
        // Get all test files in the tests directory
        $projectPath = $this->getProjectPath();
        $testsPath = $projectPath . \DIRECTORY_SEPARATOR . 'tests';

        $missing = $this->validator->findFilesWithoutCovers($testsPath);

        $failures = [];
        foreach ($missing as $filename) {
            $failures[] = \sprintf(
                'Test file (%s) does not contain @covers or @coversNothing',
                \str_replace($testsPath, 'tests', $filename)
            );
        }

        // If there are failures, fail
        if (\count($failures) > 0) {
            self::fail(\implode(\PHP_EOL, $failures));
        }

        // All good, increment count
        $this->addToAssertionCount(1);
    }
}
