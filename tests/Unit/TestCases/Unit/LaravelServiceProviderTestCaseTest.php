<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\TestCases\Unit;

use Eonx\TestUtils\Helpers\ApplyFuzziness;
use Eonx\TestUtils\Helpers\Interfaces\ApplyFuzzinessInterface;
use Eonx\TestUtils\TestCases\UnitTestCase;
use stdClass;
use Tests\Eonx\TestUtils\Stubs\TestCases\Unit\LaravelServiceProviderTestCaseStub;
use Tests\Eonx\TestUtils\Stubs\Vendor\Illuminate\EmptyServiceProviderStub;
use Tests\Eonx\TestUtils\Stubs\Vendor\Illuminate\ServiceProviderStub;

/**
 * @covers \Eonx\TestUtils\TestCases\Unit\LaravelServiceProviderTestCase
 */
class LaravelServiceProviderTestCaseTest extends UnitTestCase
{
    /**
     * Tests that testBindings tests that bindings are bound when there is nothing to be bound.
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     */
    public function testTestBindingsEmptyProvider(): void
    {
        $testCase = new LaravelServiceProviderTestCaseStub(
            [],
            EmptyServiceProviderStub::class
        );

        $testCase->testBindings();

        // If no exceptions occurred we're great.
        $this->addToAssertionCount(1);
    }

    /**
     * Tests that testBindings tests that bindings are bound.
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     */
    public function testTestBindings(): void
    {
        $testCase = new LaravelServiceProviderTestCaseStub(
            [
                ApplyFuzzinessInterface::class => ApplyFuzziness::class,
                stdClass::class => stdClass::class,
                'string' => stdClass::class,
            ],
            ServiceProviderStub::class
        );

        $testCase->testBindings();

        // If no exceptions occurred we're great.
        $this->addToAssertionCount(1);
    }
}
