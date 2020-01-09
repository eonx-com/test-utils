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
     *
     * @return mixed A preprogrammed response.
     *
     * @noinspection ParameterDefaultValueIsNotNullInspection Non null default is required to operate
     */
    protected function returnOrThrowResponse(string $method, $default = self::NOT_PROVIDED)
    {
        // If we dont have a default value provided, and there are no responses defined
        // for this method, we will throw. For no throw behaviour, this method must be
        // provided with a default value.
        if (\array_key_exists($method, $this->responses) === false &&
            $default === self::NOT_PROVIDED) {
            throw new NoResponsesConfiguredException(\sprintf(
                'No responses found in stub for method "%s"',
                $method
            ));
        }

        $response = $default;

        // If we have the method defined in the responses array, shift a response
        // from that array (or use the default if we've run out of responses.
        if (\array_key_exists($method, $this->responses) === true) {
            $response = \array_shift($this->responses[$method]) ?? $response;
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
}
