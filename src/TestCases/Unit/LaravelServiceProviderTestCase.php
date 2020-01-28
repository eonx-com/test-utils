<?php
declare(strict_types=1);

namespace Eonx\TestUtils\TestCases\Unit;

use Eonx\TestUtils\Stubs\Vendor\Illuminate\Container\ContainerStub;
use Eonx\TestUtils\TestCases\UnitTestCase;
use Illuminate\Support\ServiceProvider;
use ReflectionClass;

abstract class LaravelServiceProviderTestCase extends UnitTestCase
{
    /**
     * Test container bindings from the register method
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException If container doesn't contain key
     * @throws \ReflectionException If reflected class doesn't exist
     */
    public function testBindings(): void
    {
        $application = $this->getContainer();

        // Create the service provider, register bindings and check they've been specified
        $class = $this->getServiceProvider();
        $provider = new $class($application);

        // Ensure this is a service provider
        /** @var \Illuminate\Support\ServiceProvider|mixed $provider */
        self::assertInstanceOf(ServiceProvider::class, $provider);

        // Register
        $provider->register();

        // Check service provider doesn't bind more than what is tested
        $expected = $this->getBindings();
        $expectedAbsrtracts = \array_keys($expected);
        $bindings = $application->getClassBindings();
        self::assertEqualsCanonicalizing($expectedAbsrtracts, $bindings);

        // Test outcomes
        foreach ($expected as $abstract => $concrete) {
            $result = $application->make($abstract);

            self::assertInstanceOf($concrete, $result);

            // If we're abstracting a class, make sure the implementation extends the class
            if (\class_exists($abstract) === true) {
                $reflected = new ReflectionClass($abstract);

                // Ignore facades bound to strings
                if (\strncmp($reflected->name, 'Illuminate\\Support\\Facades', 26) === 0) {
                    continue;
                }

                self::assertInstanceOf($abstract, $result);
            }

            // If we're abstracting an interface, make sure concrete implements interface
            if (\interface_exists($abstract) === true) {
                self::assertInstanceOf($abstract, $result);
            }
        }
    }

    /**
     * Get expected bindings from the container
     *
     * @phpstan-return array<string, class-string>
     *
     * @return string[]
     */
    abstract protected function getBindings(): array;

    /**
     * Get service provider class
     *
     * @phpstan-return class-string
     *
     * @return string
     */
    abstract protected function getServiceProvider(): string;

    /**
     * Sets up the container. Override this method to set up services that are required
     * for testing a service provider.
     *
     * @return \Eonx\TestUtils\Stubs\Vendor\Illuminate\Container\ContainerStub
     */
    protected function getContainer(): ContainerStub
    {
        return new ContainerStub();
    }
}
