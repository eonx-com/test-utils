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
     * This method can be used by a test case to find the project path to do assertions
     * against the project: for example, the CoversTest that ships with this package
     * needs to know the project location to make assertions about the project.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.Superglobals) Required to interrogate phpunit's configuration
     *
     * @codeCoverageIgnore It isnt possible to test this method without modifying $GLOBALS
     *   which will interact badly with phpunit while it runs.
     */
    protected function getProjectPath(): string
    {
        // If we've got a full phpunit run, we know where the configuration file is
        // and it is located in the root project directory by convention.
        if (isset($GLOBALS['__PHPUNIT_CONFIGURATION_FILE'])) {
            return \dirname($GLOBALS['__PHPUNIT_CONFIGURATION_FILE']);
        }

        // If we dont have argv or there are no arguments to be found, we dont know
        // how to resolve the root project path.
        if (isset($GLOBALS['argv']) === false || \count($GLOBALS['argv']) <= 0) {
            self::fail('Unable to determine project path.');
        }

        // If we've been run by the commandline, lets find the project path based on
        // the phpunit executable, which should be
        // `project_root/vendor/phpunit/phpunit/phpunit`
        return \dirname($GLOBALS['argv'][0], 4);
    }
}
