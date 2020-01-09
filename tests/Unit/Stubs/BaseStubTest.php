<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\Stubs;

use Eonx\TestUtils\Exceptions\Stubs\NoResponsesConfiguredException;
use Eonx\TestUtils\TestCases\UnitTestCase;
use Exception;
use RuntimeException;
use Tests\Eonx\TestUtils\Stubs\Stubs\BaseStubStub;

/**
 * @covers \Eonx\TestUtils\Stubs\BaseStub
 *
 * @SuppressWarnings(PHPMD.EmptyCatchBlock) Required to test
 */
class BaseStubTest extends UnitTestCase
{
    /**
     * Tests typical stub operation.
     *
     * @return void
     */
    public function testStubOperation(): void
    {
        $stub = new BaseStubStub([
            'example' => [
                'out-1',
                'out-2',
                new Exception('throws')
            ]
        ]);

        $expectedCalls = [
            ['arg' => 'in-1'],
            ['arg' => 'in-2'],
            ['arg' => 'in-3'],
        ];

        $first = $stub->example('in-1');
        $second = $stub->example('in-2');

        $exception = null;
        try {
            $stub->example('in-3');
        } /** @noinspection BadExceptionsProcessingInspection */ catch (Exception $exception) {
        }

        self::assertInstanceOf(Exception::class, $exception);
        self::assertSame($expectedCalls, $stub->getExampleCalls());
        self::assertSame('out-1', $first);
        self::assertSame('out-2', $second);
    }

    /**
     * Tests typical stub operation.
     *
     * @return void
     */
    public function testUnconfiguredStub(): void
    {
        $stub = new BaseStubStub();

        $expectedCalls = [];

        self::assertSame($expectedCalls, $stub->getExampleCalls());
    }

    /**
     * Tests an incorrectly configured get<Method>Calls function.
     *
     * @return void
     */
    public function testNoResponesConfigured(): void
    {
        $stub = new BaseStubStub();

        $this->expectException(NoResponsesConfiguredException::class);
        $this->expectExceptionMessage('No responses found in stub for method "example"');

        $stub->example('arg');
    }
}
