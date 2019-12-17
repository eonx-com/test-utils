<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\TestCases;

use EoneoPay\ApiFormats\Bridge\Laravel\Responses\NoContentApiResponse;
use Eonx\TestUtils\TestCases\UnitTestCase;
use PHPUnit\Framework\AssertionFailedError;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \Eonx\TestUtils\TestCases\UnitTestCase::assertEmptyResponse
 */
class AssertEmptyResponseTest extends UnitTestCase
{
    /**
     * Test to assert that a empty response which is no a NoContentApiResponse passes.
     *
     * @return void
     */
    public function testEmptyResponseWhenItsNotANoContentApiResponse(): void
    {
        $response = new Response('', 204);

        self::assertEmptyResponse(204, $response);
    }

    /**
     * Test to assert that a empty response which is a NoContentApiResponse passes.
     *
     * @return void
     */
    public function testEmptyResponseWhenItsNoContentApiResponse(): void
    {
        $response = new NoContentApiResponse(204);

        self::assertEmptyResponse(204, $response);
    }

    /**
     * Test assertion fails when response is not empty.
     *
     * @return void
     */
    public function testAssertionFailsWhenResponseNotEmpty(): void
    {
        $response = new Response('{}', 204, ['content-type' => 'application/json']);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage('Expected response to be empty but contained: {}');

        self::assertEmptyResponse(204, $response);
    }

    /**
     * Test assertion fails when response is empty but status does not match.
     *
     * @return void
     */
    public function testAssertionFailsWhenResponseStatusNotIdentical(): void
    {
        $response = new Response('', 201);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage('Expected response status to be 204 but found 201');

        self::assertEmptyResponse(204, $response);
    }
}
