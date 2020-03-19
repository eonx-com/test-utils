<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\TestCases\UnitTestCase;

use Eonx\TestUtils\TestCases\UnitTestCase;
use PHPUnit\Framework\AssertionFailedError;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \Eonx\TestUtils\TestCases\UnitTestCase::assertResponse
 */
class AssertResponseTest extends UnitTestCase
{
    /**
     * Generate test cases to test response assertions.
     *
     * @return mixed[]
     */
    public function generateTestCases(): iterable
    {
        yield 'Response and status match.' => [
            'response' => new Response('{}', 202, ['content-type' => 'application/json']),
            'expectedStatus' => 202,
            'expectedContent' => [],
            'exception' => null
        ];

        yield 'Response matches but status does not.' => [
            'response' => new Response('{}', 202, ['content-type' => 'application/json']),
            'expectedStatus' => 204,
            'expectedContent' => [],
            'exception' => new AssertionFailedError(
                'Content matched, but expected HTTP status code (204) did not match actual (202) code.'
            )
        ];

        yield 'Status matches but response content does not.' => [
            'response' => new Response('{"abc": "xyz"}', 202, ['content-type' => 'application/json']),
            'expectedStatus' => 202,
            'expectedContent' => [],
            'exception' => new AssertionFailedError('Failed asserting that two arrays are equal.')
        ];

        yield 'Response can be matched fuzzily' => [
            'response' => new Response(
                '{"abc": "xyz", "date": "2019-10-10"}',
                200,
                ['content-type' => 'application/json']
            ),
            'expectedStatus' => 200,
            'expectedContent' => [
                'abc' => 'xyz',
                'date' => ':fuzzy:'
            ],
            'exception' => null
        ];

        yield 'Response has an exception' => [
            'response' => new Response(
                '{"code": "5400", "sub_code": "1", "message": "Validation failed.", "violations": {"key": "missing"}}',
                400,
                ['content-type' => 'application/json']
            ),
            'expectedStatus' => 200,
            'expectedContent' => [],
            'exception' => new AssertionFailedError(
                <<<EOF
Failed with error code (5400), sub code (1) and error: Validation failed.

And Violations: Array
(
    [key] => missing
)
EOF
            )
        ];
    }

    /**
     * Test the assertResponse assertion.
     *
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @param int $expectedStatus
     * @param mixed[] $expectedContent
     * @param \PHPUnit\Framework\AssertionFailedError|null $exception
     *
     * @return void
     *
     * @dataProvider generateTestCases
     */
    public function testResponseAssertion(
        Response $response,
        int $expectedStatus,
        array $expectedContent,
        ?AssertionFailedError $exception = null
    ): void {
        if ($exception !== null) {
            $this->expectException(\get_class($exception));
            $this->expectExceptionMessage($exception->getMessage());
        }

        self::assertResponse($expectedContent, $expectedStatus, $response);
    }
}
