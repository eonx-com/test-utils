<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Stubs\TestCases\Unit;

use Eonx\TestUtils\TestCases\Unit\LaravelServiceProviderTestCase;

class LaravelServiceProviderTestCaseStub extends LaravelServiceProviderTestCase
{
    /**
     * @phpstan-var array<string, class-string>
     *
     * @var string[]
     */
    private $bindings;

    /**
     * @phpstan-var class-string
     *
     * @var string
     */
    private $serviceProvider;

    /**
     * Constructor
     *
     * @phpstan-param array<string, class-string> $bindings
     * @phpstan-param class-string $serviceProvider
     *
     * @param string[] $bindings
     * @param string $serviceProvider
     */
    public function __construct(array $bindings, string $serviceProvider)
    {
        parent::__construct();

        $this->bindings = $bindings;
        $this->serviceProvider = $serviceProvider;
    }

    /**
     * {@inheritdoc}
     */
    protected function getBindings(): array
    {
        return $this->bindings;
    }

    /**
     * {@inheritdoc}
     */
    protected function getServiceProvider(): string
    {
        return $this->serviceProvider;
    }
}
