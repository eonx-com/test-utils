<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Stubs\Validation;

use Eonx\TestUtils\Stubs\BaseStub;
use Eonx\TestUtils\Validation\Interfaces\CodeCoverageValidatorInterface;

/**
 * @coversNothing
 */
class CodeCoverageValidatorStub extends BaseStub implements CodeCoverageValidatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function findFilesWithoutCovers(string $basePath): array
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__);
    }
}
