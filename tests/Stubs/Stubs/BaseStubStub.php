<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Stubs\Stubs;

use Eonx\TestUtils\Stubs\BaseStub;

/**
 * @coversNothing
 */
class BaseStubStub extends BaseStub
{
    /**
     * Returns calls to example().
     *
     * @return mixed[]
     */
    public function getExampleCalls(): array
    {
        return $this->getCalls('example');
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
     * A method that will have no configured responses.
     *
     * @return mixed
     */
    public function badReturn()
    {
        return $this->returnOrThrowResponse('_not_defined');
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
        $this->doStubCall(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__);
    }

    /**
     * Test for a callable response.
     *
     * @param string $arg1
     * @param int $arg2
     *
     * @return float
     */
    public function callable(string $arg1, int $arg2): float
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, null, \func_get_args());
    }
}
