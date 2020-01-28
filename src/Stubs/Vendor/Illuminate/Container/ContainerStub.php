<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Stubs\Vendor\Illuminate\Container;

use Illuminate\Container\Container;

class ContainerStub extends Container
{
    /**
     * Stores bindings that were made in the container for comparisons during testing.
     *
     * @var mixed[]
     */
    private $classBindings = [];

    /**
     * {@inheritdoc}
     */
    public function bind($abstract, $concrete = null, $shared = null): void
    {
        $this->classBindings[] = $abstract;

        parent::bind($abstract, $concrete, $shared ?? false);
    }

    /**
     * Returns class bindings.
     *
     * @return mixed[]
     */
    public function getClassBindings(): array
    {
        return $this->classBindings;
    }

    /**
     * Resets class bindings back to empty so that tests can assert
     * against only things the provider has added.
     *
     * @return void
     */
    public function resetClassBindings(): void
    {
        $this->classBindings = [];
    }
}
