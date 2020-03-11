<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Stubs;

final class ExpectedCall
{
    /**
     * @var mixed[]
     */
    private $args;

    /**
     * @var mixed
     */
    private $returnValue;

    /**
     * Constructor
     *
     * @param mixed[] $args
     * @param mixed $returnValue
     */
    public function __construct(array $args, $returnValue)
    {
        $this->args = $args;
        $this->returnValue = $returnValue;
    }

    /**
     * @return mixed[]
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @return mixed
     */
    public function getReturnValue()
    {
        return $this->returnValue;
    }
}
