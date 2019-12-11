<?php
declare(strict_types=1);

namespace Eonx\TestUtils\TestCases\Traits;

use Eonx\TestUtils\Constraints\ArraySameWithDates;
use Eonx\TestUtils\TestCases\TestCase;

trait AssertTrait
{
    /**
     * Assert that two arrays provided are same with flat dates.
     *
     * @param mixed[] $expected
     * @param mixed[] $actual
     *
     * @return void
     */
    public function assertArraySameWithDates(array $expected, array $actual): void
    {
        $constraint = new ArraySameWithDates($expected);

        TestCase::assertThat($actual, $constraint);
    }
}
