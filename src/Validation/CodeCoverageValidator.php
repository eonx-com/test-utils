<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Validation;

use Eonx\TestUtils\Validation\Interfaces\CodeCoverageValidatorInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

final class CodeCoverageValidator implements CodeCoverageValidatorInterface
{
    /**
     * Returns an array of files that do not contain a covers annotation.
     *
     * @param string $basePath
     *
     * @return string[]
     */
    public function findFilesWithoutCovers(string $basePath): array
    {
        $filenames = $this->getTestFilenames($basePath);

        // Captures all files missing covers
        $missing = [];

        foreach ($filenames as $filename) {
            // Read file
            $contents = \file($filename);

            // If file is unreadable, skip
            if ($contents === false) {
                continue;
            }

            foreach ($contents as $line) {
                if (\strncmp($line, ' * @covers', 10) === 0) {
                    continue 2;
                }
            }

            $missing[] = $filename;
        }

        return $missing;
    }

    /**
     * Get test files from the tests directory
     *
     * @param string $path The path to search within
     *
     * @return string[]
     */
    private function getTestFilenames(string $path): array
    {
        $directory = new RecursiveDirectoryIterator($path);
        $iterator = new RecursiveIteratorIterator($directory);
        $matches = new RegexIterator($iterator, '/.*\.php$/', RegexIterator::GET_MATCH);

        $filenames = [];

        foreach ($matches as $files) {
            $filenames[] = $files;
        }

        return \count($filenames) === 0 ? [] : \array_merge(... $filenames);
    }
}
