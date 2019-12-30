<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\Constraints;

use Eonx\TestUtils\Constraints\JsonSameAsArray;
use Eonx\TestUtils\TestCases\UnitTestCase;
use PHPUnit\Framework\AssertionFailedError;

/**
 * @covers \Eonx\TestUtils\Constraints\JsonSameAsArray
 */
class JsonSameAsArrayTest extends UnitTestCase
{
    /**
     * Test to make sure if arrays match, constraint passes.
     *
     * @return void
     */
    public function testConstraintPassesWithValidArrays(): void
    {
        $json = '{"abc": "xyz"}';
        $expected = ['abc' => 'xyz'];

        $constraint = new JsonSameAsArray($expected);
        $passes = $constraint->evaluate($json, '', true);

        self::assertTrue($passes);
    }

    /**
     * Test to make sure test fails when string provided is not a valid json.
     *
     * @return void
     */
    public function testTestFailsWhenStringNotJson(): void
    {
        $invalidJson = '{"abc": xyz}';
        $constraint = new JsonSameAsArray([]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            <<<EOF
Failed asserting that '{"abc": xyz}' is valid JSON (Syntax error, malformed JSON).
EOF
        );
        $constraint->evaluate($invalidJson);
    }

    /**
     * Test string representation of constraint.
     *
     * @return void
     */
    public function testToString(): void
    {
        $constraint = new JsonSameAsArray(['key' => 'value']);

        $string = $constraint->toString();

        self::assertSame(
            <<<EOF
is same as Array &0 (
    'key' => 'value'
)
EOF,
            $string
        );
    }
}
