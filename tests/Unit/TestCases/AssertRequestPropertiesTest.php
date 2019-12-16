<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\TestCases;

use Eonx\TestUtils\TestCases\UnitTestCase;
use LoyaltyCorp\RequestHandlers\Request\RequestObjectInterface;
use PHPUnit\Framework\AssertionFailedError;
use Tests\Eonx\TestUtils\Stubs\Helpers\RequestObjects\TestRequestStub;

/**
 * @covers \Eonx\TestUtils\TestCases\UnitTestCase::assertRequestProperties
 */
class AssertRequestPropertiesTest extends UnitTestCase
{
    /**
     * Generate test cases to test assertion.
     *
     * @return mixed[]
     */
    public function generateTestCases(): iterable
    {
        yield 'When expected does not match request object.' => [
            'object' => new TestRequestStub(true, 'John'),
            'expected' => ['active' => false, 'name' => 'Doe'],
            'exception' => new AssertionFailedError(
                'Failed asserting that request object matches expected array.'
            )
        ];

        yield 'When expected matches request object.' => [
            'object' => new TestRequestStub(true, 'John'),
            'expected' => ['name' => 'John', 'active' => true],
            'exception' => null
        ];
    }

    /**
     * Test assertion against data provider.
     *
     * @param \LoyaltyCorp\RequestHandlers\Request\RequestObjectInterface $object
     * @param mixed[] $expected
     * @param \PHPUnit\Framework\AssertionFailedError|null $exception
     *
     * @dataProvider generateTestCases
     */
    public function testAssertion(
        RequestObjectInterface $object,
        array $expected,
        ?AssertionFailedError $exception
    ): void {
        if ($exception instanceof AssertionFailedError === true) {
            $this->expectException(AssertionFailedError::class);
            $this->expectExceptionMessage($exception->getMessage());
        }

        self::assertRequestProperties($expected, $object);
    }
}