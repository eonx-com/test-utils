<?php
declare(strict_types=1);

namespace Eonx\TestUtils\TestCases\Traits;

use Eonx\TestUtils\Constraints\ArraySameWithDates;
use Eonx\TestUtils\TestCases\Exceptions\InvalidParentClassException;
use PHPUnit\Framework\Assert;

trait AssertTrait
{
    /**
     * Assert that two arrays provided are same with flat dates.
     *
     * @param mixed[] $expected
     * @param mixed[] $actual
     *
     * @return void
     *
     * @throws \Exception
     */
    public static function assertArraySameWithDates(array $expected, array $actual): void
    {
        $constraint = new ArraySameWithDates($expected);

        static::assertThat($actual, $constraint);
    }
}
