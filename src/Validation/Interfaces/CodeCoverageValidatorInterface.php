<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Validation\Interfaces;

interface CodeCoverageValidatorInterface
{
    /**
     * Returns an array of files that do not contain a covers annotation.
     *
     * @param string $basePath
     *
     * @return string[]
     */
    public function findFilesWithoutCovers(string $basePath): array;
}
