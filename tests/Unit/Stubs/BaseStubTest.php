<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\Stubs;

use Eonx\TestUtils\Exceptions\Stubs\NoResponsesConfiguredException;
use Eonx\TestUtils\TestCases\UnitTestCase;
use Exception;
use RuntimeException;
use Tests\Eonx\TestUtils\Stubs\Stubs\BaseStubCustomisableResponseStub;
use Tests\Eonx\TestUtils\Stubs\Stubs\BaseStubStub;

/**
 * @covers \Eonx\TestUtils\Stubs\BaseStub
 *
 * @SuppressWarnings(PHPMD) Required to test
 */
class BaseStubTest extends UnitTestCase
{
    /**
     * Tests that we can customise response resolution.
     *
     * @return void
     */
    public function testCustomisableResponses(): void
    {
        $stub = new BaseStubCustomisableResponseStub();

        $result = $stub->example('return should be this');

        self::assertSame('return should be this', $result);
    }

    /**
     * Tests that the default value for doStubCall works.
     *
     * @return void
     */
    public function testDefaultValue(): void
    {
        $stub = new BaseStubStub();

        $result = $stub->defaultVal();

        self::assertSame('string', $result);
    }

    /**
     * Tests that the default value for doStubCall works.
     *
     * @return void
     */
    public function testEmptyResponses(): void
    {
        $stub = new BaseStubStub([
            'example' => []
        ]);

        $this->expectException(NoResponsesConfiguredException::class);
        $this->expectExceptionMessage('No responses found in stub for method "Tests\Eonx\TestUtils\Stubs\Stubs\BaseStubStub::example"'); // phpcs:ignore

        $stub->example('string');
    }

    /**
     * Tests that a non existant method to getCalls() throws.
     *
     * @return void
     */
    public function testGetCallBadMethod(): void
    {
        $stub = new BaseStubStub();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Method "purple" does not exist on this stub.');

        $stub->getCalls('purple');
    }

    /**
     * Tests a callable response
     *
     * @return void
     */
    public function testMethodMissing(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The method "nonExistantMethod" does not exist on "Tests\Eonx\TestUtils\Stubs\Stubs\BaseStubStub" and cannot have responses configured.'); // phpcs:ignore

        new BaseStubStub([
            'nonExistantMethod' => 'out'
        ]);
    }

    /**
     * Tests an incorrectly configured get<Method>Calls function.
     *
     * @return void
     */
    public function testNoDefaultNoResolvedValue(): void
    {
        $stub = new BaseStubStub([
            'example' => null
        ]);

        $result = $stub->example('arg');

        self::assertNull($result);
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
        $this->expectExceptionMessage('No responses found in stub for method "Tests\Eonx\TestUtils\Stubs\Stubs\BaseStubStub::example"'); // phpcs:ignore

        $stub->example('arg');
    }

    /**
     * Tests that the default value for doStubCall works.
     *
     * @return void
     */
    public function testNullArrayValue(): void
    {
        $stub = new BaseStubStub([
            'example' => [null]
        ]);

        $result = $stub->example('string');

        self::assertNull($result);
    }

    /**
     * Tests a callable response
     *
     * @return void
     */
    public function testScalarAlwaysRespond(): void
    {
        $stub = new BaseStubStub([
            'example' => 'out'
        ]);

        $result = $stub->example('in');
        $result2 = $stub->example('in');
        $result3 = $stub->example('in');

        self::assertSame('out', $result);
        self::assertSame('out', $result2);
        self::assertSame('out', $result3);
    }

    /**
     * Tests a callable response
     *
     * @return void
     */
    public function testStubCallable(): void
    {
        $stub = new BaseStubStub([
            'callable' => static function (string $arg1, int $arg2): float {
                return \mb_strlen($arg1) * $arg2 / 100;
            }
        ]);

        $expectedCalls = [
            ['arg1' => 'long', 'arg2' => 56]
        ];

        $result = $stub->callable('long', 56);

        self::assertSame(2.24, $result);
        self::assertSame($expectedCalls, $stub->getCalls('callable'));
    }

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

        $stub->resetStubCalls();

        self::assertSame([], $stub->getExampleCalls());
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
}
