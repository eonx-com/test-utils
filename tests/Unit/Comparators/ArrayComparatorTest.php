<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\Comparators;

use Eonx\TestUtils\Comparators\ArrayComparator;
use Eonx\TestUtils\TestCases\UnitTestCase;
use SebastianBergmann\Comparator\ComparisonFailure;
use SebastianBergmann\Comparator\Factory;

class ArrayComparatorTest extends UnitTestCase
{
    public function testValuesNotShortened(): void
    {
        $comparator = new ArrayComparator();
        $comparator->setFactory(Factory::getInstance());

        $expected = [
            'value' => 'THIS VALUE IS REALLY LONG AND MIGHT GET TRUNCATED BY PHPUNIT'
        ];
        $expectedString = 'Array (
    \'value\' => \'THIS VALUE IS REALLY LONG AND MIGHT GET TRUNCATED BY PHPUNIT\'
)';

        $actual = [
            'notvalue' => 'THIS VALUE IS REALLY LONG AND MIGHT GET TRUNCATED BY PHPUNIT'
        ];
        $actualString = 'Array (
    \'notvalue\' => \'THIS VALUE IS REALLY LONG AND MIGHT GET TRUNCATED BY PHPUNIT\'
)';

        $exception = null;
        try {
            $comparator->assertEquals($expected, $actual);
        } catch (ComparisonFailure $exception) {
        }

        self::assertInstanceOf(ComparisonFailure::class, $exception);

        self::assertEquals($actualString, $exception->getActualAsString());
        self::assertEquals($expectedString, $exception->getExpectedAsString());
    }
}
