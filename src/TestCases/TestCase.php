<?php
declare(strict_types=1);

namespace Eonx\TestUtils\TestCases;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * @coversNothing
 */
abstract class TestCase extends PHPUnitTestCase
{
    /**
     * Returns the base path of the project (the location where the phpunit.xml file
     * being used for the test run is located).
     *
     * @return string
     */
    protected function getProjectPath(): string
    {
        // If we've got a full phpunit run, we know where the configuration file is
        // and it is located in the root project directory by convention.
        if (isset($GLOBALS['__PHPUNIT_CONFIGURATION_FILE'])) {
            return \dirname($GLOBALS['__PHPUNIT_CONFIGURATION_FILE']);
        }

        // If we've been run by the commandline, lets find the project path based on
        // the phpunit executable, which should be
        // `project_root/vendor/phpunit/phpunit/phpunit`
        if (isset($GLOBALS['argv']) && \count($GLOBALS['argv']) > 0) {
            return \dirname($GLOBALS['argv'][0], 4);
        }

        // I havent been taught to understand project structures :'(
        self::fail('Unable to determine project path.');

        // Method requires a return because phpstorm cannot understand self::fail
        return 'never-got-here'; // @codeCoverageIgnore
    }
}
