<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Stubs\Stubs;

use Eonx\TestUtils\Stubs\BaseStub;

/**
 * @coversNothing
 *
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 */
class BaseStubStub extends BaseStub
{
    /**
     * A method that will have no configured responses.
     *
     * @return mixed
     */
    public function badReturn()
    {
        return $this->doStubCall('_not_defined');
    }

    /**
     * Test for a callable response.
     *
     * @param string $arg1
     * @param int $arg2
     *
     * @return float
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) Not unused
     */
    public function callable(string $arg1, int $arg2): float
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars());
    }

    /**
     * Test default value.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) Not unused
     */
    public function defaultVal(): string
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), 'string');
    }

    /**
     * Example method for base stub functionality..
     *
     * @param string $arg
     *
     * @return string|null
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) Not unused
     */
    public function example(string $arg): ?string
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars());
    }

    /**
     * Badly configured get calls method.
     *
     * @return mixed[]
     */
    public function getBadness(): array
    {
        return $this->getCalls('badness');
    }

    /**
     * Returns calls to example().
     *
     * @return mixed[]
     */
    public function getExampleCalls(): array
    {
        return $this->getCalls('example');
    }
}
