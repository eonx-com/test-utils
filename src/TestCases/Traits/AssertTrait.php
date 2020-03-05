<?php
declare(strict_types=1);

namespace Eonx\TestUtils\TestCases\Traits;

use Doctrine\ORM\EntityManagerInterface;
use EoneoPay\ApiFormats\Bridge\Laravel\Responses\NoContentApiResponse;
use Eonx\TestUtils\Constraints\ArraySame;
use Eonx\TestUtils\Constraints\ArraySameWithDates;
use Eonx\TestUtils\Constraints\DoctrineUnitOfWorkEmpty;
use Eonx\TestUtils\Constraints\JsonSameAsArray;
use Eonx\TestUtils\Constraints\RequestProperties;
use Eonx\TestUtils\Constraints\ResponseNoException;
use Eonx\TestUtils\Constraints\SymfonyConstraintViolation;
use Eonx\TestUtils\Stubs\Interfaces\Eonx\Search\ClientStubInterface;
use LoyaltyCorp\RequestHandlers\Request\RequestObjectInterface;
use PHPUnit\Framework\Constraint\IsIdentical;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * AssertTrait that contains all custom assertions.
 */
trait AssertTrait
{
    /**
     * Assert an array is the same with allowable fuzzy keys.
     *
     * @param mixed[] $expected The array to compare with array $actual
     * @param mixed[] $actual The array to compare with array $expected
     * @param string $message
     *
     * @return void
     */
    public static function assertArrayFuzzy(array $expected, array $actual, string $message = ''): void
    {
        $constraint = new ArraySame($expected);

        static::assertThat($actual, $constraint, $message);
    }

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
     * Asserts that the violation list results in a given string output.
     *
     * @param string $expected
     * @param \Symfony\Component\Validator\ConstraintViolationListInterface $violationList
     *
     * @return void
     */
    public static function assertConstraints(string $expected, ConstraintViolationListInterface $violationList): void
    {
        $constraint = new SymfonyConstraintViolation($expected);

        static::assertThat($violationList, $constraint);
    }

    /**
     * Ensures that the search system received the expected document ids for update.
     *
     * @phpstan-param array<string, array<string>> $expectedValues
     *
     * @param string[][] $expectedValues
     * @param \Eonx\TestUtils\Stubs\Interfaces\Eonx\Search\ClientStubInterface $client
     *
     * @return void
     */
    public static function assertDocumentIdsUpdated(array $expectedValues, ClientStubInterface $client): void
    {
        $actions = $client->getBulkActions();

        $documents = [];
        foreach ($actions as $action) {
            $documents[$action->getIndex()][] = $action->getDocumentAction()->getDocumentId();
        }

        $constraint = new ArraySame($expectedValues);

        static::assertThat($documents, $constraint);
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
     * Asserts that the request object has the expected properties.
     *
     * @param mixed[] $expected
     * @param \LoyaltyCorp\RequestHandlers\Request\RequestObjectInterface $instance
     * @param string $message
     *
     * @return void
     */
    public static function assertRequestProperties(
        array $expected,
        RequestObjectInterface $instance,
        string $message = ''
    ): void {
        $constraint = new RequestProperties($expected);

        static::assertThat($instance, $constraint, $message);
    }

    /**
     * Assert an HTTP response matches the expected response contents and response code.
     *
     * If the code does not match, the response will still be checked. If an error is present, the error message, code
     *  and sub code will be set as a failure message.
     *
     * @param mixed[] $expectedContent Expected contents.
     * @param int $expectedStatus Expected HTTP status code.
     * @param \Symfony\Component\HttpFoundation\Response $response Actual HTTP response object.
     *
     * @return void
     */
    public static function assertResponse(
        array $expectedContent,
        int $expectedStatus,
        Response $response
    ): void {
        $content = (string)$response->getContent();

        // If status codes match, just check response.
        if ($expectedStatus === $response->getStatusCode()) {
            static::assertThat($response->getStatusCode(), new IsIdentical($expectedStatus));
            static::assertJsonEqualsStringFuzzily($expectedContent, $content);

            return;
        }

        // Status codes did not match, thus check if response has an exception.
        static::assertResponseNoException($response);
        // No exception found, compare the expected and actual.
        static::assertJsonEqualsStringFuzzily($expectedContent, $content);
        // Excepted matches actual response, that means status is a mismatch.
        static::assertThat(
            $response->getStatusCode(),
            new IsIdentical($expectedStatus),
            \sprintf(
                'Content matched, but expected HTTP status code (%s) did not match actual (%s) code.',
                $expectedStatus,
                $response->getStatusCode()
            )
        );
        // @codeCoverageIgnoreStart coverage artifact
    }
    // @codeCoverageIgnoreEnd

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
     * Ensure the unit of work has no changes in limbo
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     *
     * @return void
     */
    public static function assertUnitOfWorkIsEmpty(EntityManagerInterface $entityManager): void
    {
        $constraint = new DoctrineUnitOfWorkEmpty();

        static::assertThat($entityManager, $constraint);
    }
}
