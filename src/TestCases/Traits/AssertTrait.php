<?php
declare(strict_types=1);

namespace Eonx\TestUtils\TestCases\Traits;

use EoneoPay\ApiFormats\Bridge\Laravel\Responses\NoContentApiResponse;
use Eonx\TestUtils\Constraints\ArraySameWithDates;
use Eonx\TestUtils\Constraints\JsonSameAsArray;
use Eonx\TestUtils\Constraints\ResponseNoException;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\IsIdentical;
use Symfony\Component\HttpFoundation\Response;

/**
 * AssertTrait that contains all custom assertions.
 */
trait AssertTrait
{
    /**
     * Assert that two arrays provided are same with flat dates.
     *
     * @param mixed[] $expected
     * @param mixed[] $actual
     * @param string $message
     *
     * @return void
     */
    public static function assertArraySameWithDates(array $expected, array $actual, string $message = ''): void
    {
        $constraint = new ArraySameWithDates($expected);

        static::assertThat($actual, $constraint, $message);
    }

    /**
     * Assert that a response is of the expected type.
     *
     * @param int $expectedStatus
     * @param \Symfony\Component\HttpFoundation\Response $response
     *
     * @return void
     */
    public static function assertEmptyResponse(int $expectedStatus, Response $response): void
    {
        if ($response instanceof NoContentApiResponse === false) {
            self::assertResponseNoException($response);
        }

        static::assertThat(
            $response->getContent(),
            new IsIdentical(''),
            \sprintf('Expected response to be empty but contained: %s', $response->getContent())
        );
        static::assertThat(
            $response->getStatusCode(),
            new IsIdentical($expectedStatus),
            \sprintf(
                'Expected response status to be %s but found %s',
                $expectedStatus,
                $response->getStatusCode()
            )
        );
    }

    /**
     * Run an assertion against JSON string to an expected array of results, skipping certain time related keys
     * example:
     * static::assertJsonEqualsStringFuzzily(
     *      ['date' => ':fuzzy:', 'example' => true],
     *      '{"date": "2019-02-02", "example": true}'
     * );.
     *
     * @param mixed[] $expected Specific array containing null values on fuzzy values
     * @param string $actual JSON Encoded string
     * @param string $message Assertion message
     *
     * @return void
     */
    public static function assertJsonEqualsStringFuzzily(array $expected, string $actual, string $message = ''): void
    {
        $constraint = new JsonSameAsArray($expected);

        static::assertThat($actual, $constraint, $message);
    }

    /**
     * Asserts that the response was not an exception.
     *
     * @param \Symfony\Component\HttpFoundation\Response $response
     *
     * @return void
     */
    public static function assertResponseNoException(Response $response): void
    {
        $constraint = new ResponseNoException();

        static::assertThat($response, $constraint);
    }

    /**
     * Base assertThat method to make sure trait user implements this.
     * This method is same signature as phpunit's base Assert::assertThat.
     *
     * @param mixed $value
     * @param \PHPUnit\Framework\Constraint\Constraint $constraint
     * @param string $message
     *
     * @return void
     */
    abstract protected static function assertThat($value, Constraint $constraint, string $message = ''): void;
}
