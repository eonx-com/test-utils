<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Stubs;

use SebastianBergmann\Comparator\ArrayComparator;
use SebastianBergmann\Comparator\ComparisonFailure;
use SebastianBergmann\Comparator\Factory;

/**
 * A base stub that adds the capability of having a return map that will
 * find method return values based on the arguments passed to the stub.
 *
 * @coversNothing
 */
abstract class MatchingStub extends BaseStub
{
    /**
     * Stores arrays of ExpectedCall objects grouped by method as the key.
     *
     * @var ExpectedCall[][]
     */
    private $responses;

    /**
     * Constructor
     *
     * @param ExpectedCall[][]|null $responses
     */
    public function __construct(?array $responses = null)
    {
        $this->responses = $responses ?? [];

        parent::__construct([]);
    }

    /**
     * Finds a response to use for the method.
     *
     * @param string $method
     * @param mixed[] $args
     * @param mixed $default
     *
     * @return mixed
     *
     * @noinspection PhpMethodNamingConventionInspection PhpMissingParentCallCommonInspection
     */
    protected function _getResponseFor(string $method, array $args, $default)
    {
        // If we dont have a response configured, we have a default - lets return it.
        if (\array_key_exists($method, $this->responses) === false) {
            return $default;
        }

        $arrayComparator = new ArrayComparator();
        $arrayComparator->setFactory(Factory::getInstance());

        // Attempt to find an ExpectedCall that matches the args we received otherwise
        // return the default value. Uses the same semantics as the assertEquals array
        // behavior.
        foreach ($this->responses[$method] as $potentialMethod) {
            try {
                $arrayComparator->assertEquals($potentialMethod->getArgs(), $args);
            } catch (ComparisonFailure $exception) {
                continue;
            }

            return $potentialMethod->getReturnValue();
        }

        return $default;
    }
}
