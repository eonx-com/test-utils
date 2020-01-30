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
    private const NOT_PROVIDED = '______NOT_PROVIDED';

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
     * Return the next item queued for response. If there is no response configured
     * but a default is provided, it will be returned instead.
     *
     * This can be called with the following snippet:
     *      return $this->returnOrThrowResponse(__FUNCTION__, 'defaultValue');
     *
     * @param string $method The name of the original method to return the response for.
     * @param mixed $default
     * @param mixed[]|null $methodArgs
     *
     * @return mixed A preprogrammed response.
     *
     * @noinspection ParameterDefaultValueIsNotNullInspection Non null default is required to operate
     */
    protected function returnOrThrowResponse(
        string $method,
        $default = self::NOT_PROVIDED,
        ?array $methodArgs = null
    ) {
        $response = $this->getResponseFor($method, $default);

        // If we got a callable and we were passed the method args, call it and
        // return its value.
        if (\is_callable($response) === true && \is_array($methodArgs) === true) {
            return \call_user_func_array($response, $methodArgs);
        }

        // If the response is throwable, we're going to throw it instead.
        if ($response instanceof Throwable === true) {
            throw $response;
        }

        // If we got here, and the response is still NOT_PROVIDED we'll return a null.
        return $response === self::NOT_PROVIDED
            ? null
            : $response;
    }

    /**
     * Save all calls made to this method.
     *
     * This can be called with the following snippet as the first line in the method:
     *      $this->saveCalls(__FUNCTION__, \get_defined_vars());
     *
     * @param string $method The method name to save data against.
     * @param mixed[] $args A key/value array of parameter names and their values.
     *
     * @return void
     */
    protected function saveCalls(string $method, array $args): void
    {
        $this->calls[$method][] = $args;
    }

    /**
     * Finds a response to use for the method.
     *
     * @param string $method
     * @param mixed $default
     *
     * @return mixed
     */
    private function getResponseFor(string $method, $default)
    {
        // If we dont have a default value provided, and there are no responses defined
        // for this method, we will throw. For no throw behaviour, this method must be
        // provided with a default value.
        if (\array_key_exists($method, $this->responses) === false &&
            $default === self::NOT_PROVIDED) {
            throw new NoResponsesConfiguredException(\sprintf(
                'No responses found in stub for method "%s::%s"',
                \get_class($this),
                $method
            ));
        }

        // If we dont have a response configured, we have a default - lets return it.
        if (\array_key_exists($method, $this->responses) === false) {
            return $default;
        }

        // If we have an array, assume it is a stack of responses and shift the first
        // response to be returned. If it is an empty array, return the default value.
        if (\is_array($this->responses[$method]) === true) {
            return \array_shift($this->responses[$method]) ?? $default;
        }

        // If we got here, the response for $method is a non array value, return it as is.
        return $this->responses[$method];
    }
}
