<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\Constraints;

use Eonx\TestUtils\Constraints\ResponseNoException;
use Eonx\TestUtils\TestCases\UnitTestCase;
use PHPUnit\Framework\AssertionFailedError;
use stdClass;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \Eonx\TestUtils\Constraints\ResponseNoException
 */
class ResponseNoExceptionTest extends UnitTestCase
{
    /**
     * Generate test cases which would return a result from
     * evaluate. The result can be either a true or false based
     * on if the constraint evaluation passes or not.
     *
     * @return mixed[]
     */
    public function generateReturnResultCases(): iterable
    {
        yield 'Object is not a valid response object.' => [
            'object' => new stdClass(),
            'result' => false
        ];

        yield 'Response has exception.' => [
            'object' => new Response(
                '{"code": "1", "sub_code": "2", "message": "Exception thrown."}',
                400,
                ['content-type' => 'application/json']
            ),
            'result' => false
        ];

        yield 'Response does not has a valid json or xml. ' => [
            'object' => new Response('da'),
            'result' => false
        ];

        yield 'Response has no exception.' => [
            'object' => new Response('<xml></xml>', 200, ['content-type' => 'application/xml']),
            'result' => true
        ];
    }

    /**
     * Test evaluate when the response content is not a valid
     * json or xml.
     *
     * @return void
     */
    public function testEvaluateFailsWhenResponseIsNotJsonOrXml(): void
    {
        $response = new Response('abc');
        $constraint = new ResponseNoException();

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage('Response does not contain a valid content-type header.');

        $constraint->evaluate($response);
    }

    /**
     * Test to assert that test fails when response contains exceptions.
     *
     * @return void
     */
    public function testEvaluateWhenResponseContainsExceptions(): void
    {
        $response = new Response(
            '{"code": "1", "sub_code": "2", "message": "Exception thrown.", "violations": {"key": "missing"}}',
            400,
            ['content-type' => 'application/json']
        );
        $constraint = new ResponseNoException();

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            <<<EOF
Failed with error code (1), sub code (2) and error: Exception thrown.

And Violations: Array
(
    [key] => missing
)
EOF
        );

        $constraint->evaluate($response);
    }

    /**
     * Test assertion when supplied response is not a valid symfony response object.
     *
     * @return void
     */
    public function testEvaluateWhenResponseIsNotValidInstance(): void
    {
        $constraint = new ResponseNoException();

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            <<<EOF
Failed asserting that stdClass Object () is an instance of class "Symfony\Component\HttpFoundation\Response".
EOF
        );

        $constraint->evaluate(new stdClass());
    }

    /**
     * Test evaluate when returnResult is set to true.
     *
     * @param mixed $object
     * @param bool $result
     *
     * @return void
     *
     * @dataProvider generateReturnResultCases
     */
    public function testEvaluateWhenReturnResultIsTrue($object, bool $result): void
    {
        $constraint = new ResponseNoException();

        $actualResult = $constraint->evaluate($object, '', true);

        self::assertSame($result, $actualResult);
    }
}
