<?php
declare(strict_types=1);

namespace Eonx\TestUtils\TestCases\Traits;

use Eonx\TestUtils\Constraints\ArraySameWithDates;
use Eonx\TestUtils\Constraints\JsonSameAsArray;

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

    /**
     * Run an assertion against JSON string to an expected array of results, skipping certain time related keys
     * example:
     * $this->>assertJsonEqualsStringFuzzily(
     *      ['date' => ':fuzzy:', 'example' => true],
     *      '{"date": "2019-02-02", "example": true}'
     * );.
     *
     * @param mixed[] $expected Specific array containing null values on fuzzy values
     * @param string $actual JSON Encoded string
     * @param string $message Assertion message
     *
     * @return void
     */
    public static function assertJsonEqualsStringFuzzily(array $expected, string $actual, string $message = ''): void
    {
        $constraint = new JsonSameAsArray($expected);

        static::assertThat($actual, $constraint, $message);
    }
}
