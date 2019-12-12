<?php
declare(strict_types=1);

namespace Eonx\TestUtils\TestCases\Traits;

use Eonx\TestUtils\Constraints\ArraySameWithDates;
use Eonx\TestUtils\TestCases\Exceptions\InvalidParentClassException;
use Eonx\TestUtils\TestCases\TestCase;

trait AssertTrait
{
    /**
     * AssertTrait constructor.
     */
    public function __construct()
    {
        if ($this instanceof TestCase === false) {
            throw new InvalidParentClassException(
                \sprintf('AssertTrait must be used by an %s class.', TestCase::class)
            );
        }
    }

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
    public function assertArraySameWithDates(array $expected, array $actual): void
    {
        $constraint = new ArraySameWithDates($expected);

        parent::assertThat($actual, $constraint);
    }
}
