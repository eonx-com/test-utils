<?php
declare(strict_types=1);

namespace Eonx\TestUtils\TestCases;

use Eonx\TestUtils\TestCases\Traits\AssertTrait;

/**
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class UnitTestCase extends TestCase
{
    use AssertTrait;
}
