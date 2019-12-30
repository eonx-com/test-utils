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
        return $this->getCalls(__FUNCTION__);
    }

    /**
     * Badly configured get calls method.
     *
     * @return mixed[]
     */
    public function getBadness(): array
    {
        return $this->getCalls(__FUNCTION__);
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
     */
    public function example(string $arg): ?string
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__);
    }
}
