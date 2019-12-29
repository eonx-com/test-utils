<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\TestCases\UnitTestCase;

use Eonx\TestUtils\TestCases\UnitTestCase;
use PHPUnit\Framework\AssertionFailedError;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \Eonx\TestUtils\TestCases\UnitTestCase::assertResponseNoException
 */
class AssertResponseNoExceptionTest extends UnitTestCase
{
    /**
     * Assert that a response with exception throws test failed exception.
     *
     * @return void
     */
    public function testResponseWithException(): void
    {
        $response = new Response(
            '{"code": "1", "sub_code": "2", "message": "Exception thrown."}',
            400,
            ['content-type' => 'application/json']
        );

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage('Failed with error code (1), sub code (2) and error: Exception thrown.');

        self::assertResponseNoException($response);
    }

    /**
     * Test that assertion passes when no exception in response.
     *
     * @return void
     */
    public function testResponseWithNoException(): void
    {
        $response = new Response(
            '{}',
            200,
            ['content-type' => 'application/json']
        );

        self::assertResponseNoException($response);
    }
}
