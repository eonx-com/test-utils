<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Stubs;

use Eonx\TestUtils\Exceptions\Stubs\NoResponsesConfiguredException;
use RuntimeException;
use Throwable;

/**
 * Base class creating stubs with spy behaviour.
 *
 * @coversNothing
 */
abstract class BaseStub
{
    /**
     * The constant used for the default value in returnOrThrowResponse to indicate
     * the calling method did not provide a default.
     *
     * @const string
     */
    protected const NOT_PROVIDED = '______NOT_PROVIDED';

    /**
     * Storage of all calls made to stubbed methods.
     *
     * Calls are keyed by method name, and as a list of arrays where method names are keys.
     *  eg; two calls calls to a method foo(int $id, string $name) would be stored as:
     *  ['foo' => [['id' => 1, 'name' => 'Bob'],['id' => 15, 'name' => 'Joe']]]
     *
     * @var mixed[]
     */
    private $calls = [];

    /**
     * List of responses to return when a given method is called.
     *
     * Response are keyed by the name of the original method that's called, returned in a FIFO manner.
     *  If Throwable (exception) is in the list, it will be thrown, instead of returned. eg; A method
     *  called 'createAction' that will return an Action entity on the first call, and an BadName exception
     *  will be stored as follows:
     *  ['createAction' => [Action(), BadNameException]]
     *
     * @var mixed[]
     */
    private $responses = [];

    /**
     * StubBase constructor.
     *
     * @param mixed[] $responses An array of responses, keyed by the method that will return them.
     *  See documentation on self::$calls for structure.
     */
    public function __construct(?array $responses = null)
    {
        if ($responses === null) {
            return;
        }

        foreach ($responses as $method => $methodResponses) {
            if (\method_exists($this, $method) === false) {
                throw new RuntimeException(\sprintf(
                    'The method "%s" does not exist on "%s" and cannot have responses configured.',
                    $method,
                    \get_class($this)
                ));
            }

            $this->responses[$method] = $methodResponses;
        }
    }

    /**
     * Get a list of calls made to a particular method.
     *
     * @param string $method The method name to return calls for.
     *
     * @return mixed[] A list of all the calls made to the original method.
     */
    public function getCalls(string $method): array
    {
        if (\method_exists($this, $method) === false) {
            throw new RuntimeException(\sprintf(
                'Method "%s" does not exist on this stub.',
                $method
            ));
        }

        return $this->calls[$method] ?? [];
    }

    /**
     * Resets the stub's record of all calls.
     *
     * @return void
     */
    public function resetStubCalls(): void
    {
        $this->calls = [];
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
     * @noinspection PhpMethodNamingConventionInspection
     */
    protected function _getResponseFor(string $method, array $args, $default) // phpcs:ignore
    {
        // If we dont have a response configured, we have a default - lets return it.
        if (\array_key_exists($method, $this->responses) === false) {
            return $default;
        }

        // If we have an array, assume it is a stack of responses and shift the first
        // response to be returned. If it is an empty array, return the default value.
        if (\is_array($this->responses[$method]) === true) {
            // If there is no responses configured, return the default.
            return \count($this->responses[$method]) === 0
                ? $default
                : \array_shift($this->responses[$method]);
        }

        // If we got here, the response for $method is a non array value, return it as is.
        return $this->responses[$method];
    }

    /**
     * Performs a stub call - recording the fact the method was called with args and
     * then returning or throwing a value. This method will work fine for void return
     * methods where you still call this method but do not return its value.
     *
     * This can be called with the following snippet as the first line in the method:
     *      $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
     *
     * @param string $method The method name to save data against.
     * @param mixed[]|null $args A key/value array of parameter names and their values.
     * @param mixed $default
     *
     * @return mixed
     *
     * @noinspection ParameterDefaultValueIsNotNullInspection
     */
    protected function doStubCall(string $method, ?array $args = null, $default = self::NOT_PROVIDED)
    {
        $this->calls[$method][] = $args;

        return $this->handleResponse($method, $args ?? [], $default);
    }

    /**
     * Previous legacy method.
     *
     * @param string $method
     * @param mixed $default
     * @param mixed[]|null $methodArgs
     *
     * @return mixed
     *
     * @deprecated use doStubCall() instead.
     *
     * @noinspection ParameterDefaultValueIsNotNullInspection
     *
     * @codeCoverageIgnore
     */
    protected function returnOrThrowResponse(
        string $method,
        $default = self::NOT_PROVIDED,
        ?array $methodArgs = null
    ) {
        return $this->handleResponse($method, $methodArgs ?? [], $default);
    }

    /**
     * Previous method, legacy.
     *
     * @param string $method
     * @param mixed[] $args
     *
     * @return void
     *
     * @deprecated use doStubCall() instead.
     *
     * @codeCoverageIgnore
     */
    protected function saveCalls(string $method, array $args): void
    {
        $this->calls[$method][] = $args;
    }

    /**
     * Resolves a response if one exists and throws or returns it.
     *
     * @param string $method
     * @param mixed[] $args
     * @param mixed $default
     *
     * @return mixed
     */
    private function handleResponse(string $method, array $args, $default)
    {
        $response = $this->_getResponseFor($method, $args, $default);

        // If we got a callable and we were passed the method args, call it to resolve the
        // response.
        if (\is_callable($response) === true) {
            $response = \call_user_func_array($response, $args);
        }

        // If the response is throwable, we're going to throw it instead.
        if ($response instanceof Throwable === true) {
            throw $response;
        }

        // The response was not resolved to a usable value.
        if ($response === self::NOT_PROVIDED) {
            throw new NoResponsesConfiguredException(\sprintf(
                'No responses found in stub for method "%s::%s"',
                \get_class($this),
                $method
            ));
        }

        // Return the resolved response.
        return $response;
    }
}
