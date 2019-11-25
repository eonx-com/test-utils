<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Stubs\Validation;

use Eonx\TestUtils\Validation\Interfaces\CodeCoverageValidatorInterface;

/**
 * @coversNothing
 */
class CodeCoverageValidatorStub implements CodeCoverageValidatorInterface
{
    /**
     * @var string[]
     */
    private $missing;

    /**
     * Constructor
     *
     * @param string[] $missing
     */
    public function __construct(array $missing)
    {
        $this->missing = $missing;
    }

    /**
     * {@inheritdoc}
     */
    public function findFilesWithoutCovers(string $basePath): array
    {
        return $this->missing;
    }
}
