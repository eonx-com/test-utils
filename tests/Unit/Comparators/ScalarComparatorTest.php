<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\Comparators;

use Eonx\TestUtils\Comparators\ScalarComparator;
use Eonx\TestUtils\TestCases\UnitTestCase;
use SebastianBergmann\Comparator\ComparisonFailure;
use SebastianBergmann\Comparator\Factory;

class ScalarComparatorTest extends UnitTestCase
{
    /**
     * Failures that the comparator should fail.
     *
     * @return mixed[]
     */
    public function getScalarFailureTestData(): iterable
    {
        return [
            ['1', 1],
            ['10', 10],
            ['', false],
            ['1', true],
            [1, true],
            [0, false],
            [0.1, '0.1'],
            [false, null],
            // Taken from original Scalar Comparator tests
            ['string', 'other string'],
            ['string', 'STRING'],
            ['STRING', 'string'],
            ['string', 'other string'],
            ['9E6666666', '9E7777777'],
            [0, 'Foobar'],
            ['Foobar', 0],
            ['10', 25],
            ['1', false],
            ['', true],
            [false, true],
            [true, false],
            [null, true],
            [0, true],
            ['0', '0.0'],
            ['0.', '0.0'],
            ['0e1', '0e2'],
            ["\n\n\n0.0", '                   0.'],
            ['0.0', '25e-10000'],
        ];
    }

    /**
     * Failures that the comparator should succeed.
     *
     * @return mixed[]
     */
    public function getScalarSuccessTestData(): iterable
    {
        return [
            [false, false],
            [true, true],
            [null, null],
            ['string', 'string'],
            [1, 1],
            [1.5, 1.5],
        ];
    }

    /**
     * Tests that when the comparator factory has our scalar comparator that assert equals behaviour
     * relating to arrays changes.
     *
     * @return void
     */
    public function testArrayAssertion(): void
    {
        $comparator = new ScalarComparator();

        Factory::getInstance()->register($comparator);

        $expected = ['thing' => 1];
        $actual = ['thing' => '1'];

        self::assertNotEquals($expected, $actual);

        Factory::getInstance()->unregister($comparator);

        self::assertEquals($expected, $actual);
    }

    /**
     * Tests that the comparator fails on conditions.
     *
     * @param mixed $expected
     * @param mixed $actual
     *
     * @return void
     *
     * @dataProvider getScalarFailureTestData
     */
    public function testScalarComparsonFailure($expected, $actual): void
    {
        $comparator = new ScalarComparator();

        $this->expectException(ComparisonFailure::class);

        /** @noinspection PhpUnitTestsInspection */
        $comparator->assertEquals($expected, $actual);
    }

    /**
     * Tests that the comparator succeeds on conditions.
     *
     * @param mixed $expected
     * @param mixed $actual
     *
     * @return void
     *
     * @dataProvider getScalarSuccessTestData
     */
    public function testScalarComparsonSuccess($expected, $actual): void
    {
        $comparator = new ScalarComparator();

        /** @noinspection PhpUnitTestsInspection */
        $comparator->assertEquals($expected, $actual);

        // Comparator doesnt throw.
        self::addToAssertionCount(1);
    }
}
