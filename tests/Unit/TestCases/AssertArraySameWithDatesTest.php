<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\TestCases;

use DateTime;
use Eonx\TestUtils\TestCases\UnitTestCase;
use PHPUnit\Framework\AssertionFailedError;

/**
 * @covers \Eonx\TestUtils\TestCases\UnitTestCase::assertArraySameWithDates
 */
class AssertArraySameWithDatesTest extends UnitTestCase
{
    /**
     * Test array same with dates works fine with date instances.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testArraySameWithDates(): void
    {
        $expected = [
            'random' => 'value',
            'date' => new DateTime('2019-10-10T00:00:00Z'),
            'deep' => [
                'deeper' => [
                    'date' => new DateTime('2019-10-10T00:00:00+0000'),
                ]
            ]
        ];

        $actual = [
            'random' => 'value',
            'date' => new DateTime('2019-10-10T00:00:00Z'),
            'deep' => [
                'deeper' => [
                    'date' => new DateTime('2019-10-10T00:00:00+0000'),
                ]
            ]
        ];

        self::assertArraySameWithDates($expected, $actual);
    }

    /**
     * Test assertions fails when dates don't match.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testArraySameWithDatesFails(): void
    {
        $expected = [
            'random' => 'value',
            'date' => new DateTime('2019-10-10T00:00:01Z')
        ];

        $actual = [
            'random' => 'value',
            'date' => new DateTime('2019-10-10T01:00:00Z')
        ];

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage('Failed asserting that two arrays are identical.');

        self::assertArraySameWithDates($expected, $actual);
    }

    /**
     * Test array same with dates fail with date instances when
     * they are from different time zones.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testArraySameWithDatesFromDifferentTimeZones(): void
    {
        $expected = [
            'random' => 'value',
            'date' => new DateTime('2019-10-10T00:00:00+0100')
        ];

        $actual = [
            'random' => 'value',
            'date' => new DateTime('2019-10-10T01:00:00Z')
        ];

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage('Failed asserting that two arrays are identical.');

        self::assertArraySameWithDates($expected, $actual);
    }
}
